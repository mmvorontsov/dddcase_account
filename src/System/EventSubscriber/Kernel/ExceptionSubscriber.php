<?php

namespace App\System\EventSubscriber\Kernel;

use App\Context\Account\Application\UseCase\ClientErrorException;
use App\Context\Account\Application\UseCase\ErrorsAwareExceptionInterface;
use App\Context\Account\Domain\DomainException;
use App\System\Common\Enum\EnvironmentEnum;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\SerializerInterface;

use function iterator_to_array;
use function strtolower;
use function ucfirst;

/**
 * Class ExceptionSubscriber
 * @package App\System\EventSubscriber\Kernel
 */
class ExceptionSubscriber implements EventSubscriberInterface
{
    /**
     * @var string
     */
    private const DEFAULT_RESPONSE_FORMAT = 'json';

    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @var string
     */
    private string $environment;

    /**
     * ExceptionSubscriber constructor.
     * @param SerializerInterface $serializer
     * @param LoggerInterface $logger
     * @param string $environment
     */
    public function __construct(SerializerInterface $serializer, LoggerInterface $logger, string $environment)
    {
        $this->serializer = $serializer;
        $this->logger = $logger;
        $this->environment = $environment;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => [
                ['handleClientErrorException', 524],
                ['handleException', 512],
            ],
        ];
    }

    /**
     * @param ExceptionEvent $event
     */
    public function handleClientErrorException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        if (!$exception instanceof ClientErrorException && !$exception instanceof DomainException) {
            return;
        }

        $request = $event->getRequest();
        $format = $request->getRequestFormat();

        $response = new Response();
        $response->headers->set('Content-Type', $request->getMimeType($format));

        $statusCode = $exception->getCode();
        if ($exception instanceof DomainException) {
            $statusCode = Response::HTTP_BAD_REQUEST;
        }

        $response->setStatusCode($statusCode);
        $data = [
            'code' => $statusCode,
            'message' => $exception->getMessage()
        ];

        if ($exception instanceof ErrorsAwareExceptionInterface) {
            $errors = $exception->getErrors();
            $data['errors'] = iterator_to_array($errors->getIterator());
        }

        $content = $this->serializer->serialize($data, $format);
        $response->setContent($content);
        $event->setResponse($response);
    }

    /**
     * @param ExceptionEvent $event
     */
    public function handleException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $request = $event->getRequest();
        $format = self::DEFAULT_RESPONSE_FORMAT;

        $response = new Response();
        $response->headers->set('Content-Type', $request->getMimeType($format));

        $statusCode = ($exception instanceof HttpExceptionInterface)
            ? $exception->getStatusCode()
            : Response::HTTP_INTERNAL_SERVER_ERROR;

        $response->setStatusCode($statusCode);

        $defaultMessage = ucfirst(strtolower(Response::$statusTexts[$statusCode] ?? 'Server Error'));
        $message = (EnvironmentEnum::PROD === $this->environment) ? $defaultMessage : $exception->getMessage();

        $this->logger->error(
            $exception->getMessage(),
            ['file' => $exception->getFile(), 'line' => $exception->getLine()]
        );

        $content = $this->serializer->serialize(['message' => $message], $format);
        $response->setContent($content);
        $event->setResponse($response);
    }
}
