<?php

namespace App\Context\Account\Infrastructure\Messaging\Transport\Serializer;

use Exception;
use InvalidArgumentException;
use App\Context\Account\AccountContext;
use App\Context\Account\Application\Message\Interservice\InterserviceMessageNameConverterInterface;
use App\Context\Account\Infrastructure\Messaging\Bus\InterserviceCommandBusInterface;
use App\Context\Account\Infrastructure\Messaging\Bus\InterserviceEventBusInterface;
use App\Context\Account\Infrastructure\Messaging\Bus\InterserviceReplyBusInterface;
use App\Context\Account\Infrastructure\Messaging\Message\DeprecatedMessageInterface;
use App\Context\Account\Infrastructure\Messaging\Message\Interservice\InterserviceCommandInterface;
use App\Context\Account\Infrastructure\Messaging\Message\Interservice\InterserviceEventInterface;
use App\Context\Account\Infrastructure\Messaging\Message\Interservice\InterserviceMessageInterface;
use App\Context\Account\Infrastructure\Messaging\Message\Interservice\InterserviceReplyInterface;
use App\Context\Account\Infrastructure\Serialization\SerializerInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\MessageDecodingFailedException;
use Symfony\Component\Messenger\Stamp\BusNameStamp;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface as MessengerSerializerInterface;
use Throwable;

use function explode;
use function str_replace;

/**
 * Class InterserviceMessageSerializer
 * @package App\Context\Account\Infrastructure\Messaging\Transport\Serializer
 */
final class InterserviceMessageSerializer implements MessengerSerializerInterface
{
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * @var InterserviceMessageNameConverterInterface
     */
    private InterserviceMessageNameConverterInterface $interserviceMessageNameConverter;

    /**
     * @var string
     */
    private string $format;

    /**
     * @var array
     */
    private array $context;

    /**
     * InterserviceMessageSerializer constructor.
     * @param SerializerInterface $serializer
     * @param InterserviceMessageNameConverterInterface $interserviceMessageNameConverter
     * @param string $format
     * @param array $context
     */
    public function __construct(
        SerializerInterface $serializer,
        InterserviceMessageNameConverterInterface $interserviceMessageNameConverter,
        string $format = 'json',
        array $context = [],
    ) {
        $this->interserviceMessageNameConverter = $interserviceMessageNameConverter;
        $this->serializer = $serializer;
        $this->format = $format;
        $this->context = $context;
    }

    /**
     * @param Envelope $envelope
     * @return array
     * @throws Exception
     */
    public function encode(Envelope $envelope): array
    {
        if (!$envelope->getMessage() instanceof InterserviceMessageInterface) {
            throw new InvalidArgumentException('Unexpected type of message.');
        }

        /** @var InterserviceMessageInterface $message */
        $message = $envelope->getMessage();
        $type = $this->interserviceMessageNameConverter->normalize($message::class);

        // TODO Refactoring
        $owner = null;

        if ($message instanceof InterserviceEventInterface) {
            [$owner] = explode('.', $type);
        } elseif ($message instanceof InterserviceReplyInterface) {
            $extraType = str_replace('reply_of:', '', $type);
            [$owner] = explode('.', $extraType);
        }

        if (null !== $owner && AccountContext::CONTEXT_ID !== $owner) {
            throw new InvalidArgumentException('Unexpected owner of event.');
        }

        return [
            'body' => $this->serializer->serialize($message, $this->format, $this->context),
            'headers' => ['type' => $type] + $this->getDeprecationHeader($message) + $this->getContentTypeHeader(),
        ];
    }

    /**
     * @param array $encodedEnvelope
     * @return Envelope
     */
    public function decode(array $encodedEnvelope): Envelope
    {
        if (empty($encodedEnvelope['body']) || empty($encodedEnvelope['headers'])) {
            throw new MessageDecodingFailedException(
                'Encoded envelope should have at least a "body" and some "headers".',
            );
        }

        if (empty($encodedEnvelope['headers']['type'])) {
            throw new MessageDecodingFailedException('Encoded envelope does not have a "type" header.');
        }

        $type = $this->interserviceMessageNameConverter->denormalize($encodedEnvelope['headers']['type']);

        try {
            $message = $this->serializer->deserialize($encodedEnvelope['body'], $type, $this->format, $this->context);
        } catch (Throwable $e) {
            $message = sprintf('Could not decode message: %s.', $e->getMessage());
            throw new MessageDecodingFailedException($message, $e->getCode(), $e);
        }

        if (isset($encodedEnvelope['headers']['deprecation'])) {
            // TODO Log deprecation
        }

        return $this->withBusNameStamp(new Envelope($message));
    }

    /**
     * @param Envelope $envelope
     * @return Envelope
     */
    private function withBusNameStamp(Envelope $envelope): Envelope
    {
        $message = $envelope->getMessage();

        return match (true) {
            $message instanceof InterserviceCommandInterface => $envelope->with(
                new BusNameStamp(InterserviceCommandBusInterface::BUS_NAME),
            ),
            $message instanceof InterserviceEventInterface => $envelope->with(
                new BusNameStamp(InterserviceEventBusInterface::BUS_NAME),
            ),
            $message instanceof InterserviceReplyInterface => $envelope->with(
                new BusNameStamp(InterserviceReplyBusInterface::BUS_NAME),
            ),
            default => throw new MessageDecodingFailedException(
                sprintf('Unexpected message type "%s".', $message::class),
            ),
        };
    }

    /**
     * @param InterserviceMessageInterface $message
     * @return array
     */
    private function getDeprecationHeader(InterserviceMessageInterface $message): array
    {
        if ($message instanceof InterserviceReplyInterface) {
            $message = $message->getTarget();
        }

        if ($message instanceof DeprecatedMessageInterface) {
            return ['deprecation' => $message->getDeprecation()];
        }

        return [];
    }

    /**
     * @return array
     */
    private function getContentTypeHeader(): array
    {
        $mimeType = $this->getMimeTypeForFormat();

        return null === $mimeType ? [] : ['content-type' => $mimeType];
    }

    /**
     * @return string|null
     */
    private function getMimeTypeForFormat(): ?string
    {
        return match ($this->format) {
            'json' => 'application/json',
            default => null,
        };
    }
}
