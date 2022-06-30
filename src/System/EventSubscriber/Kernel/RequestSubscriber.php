<?php

namespace App\System\EventSubscriber\Kernel;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

use function is_array;
use function json_decode;
use function str_starts_with;

/**
 * Class RequestSubscriber
 * @package App\System\EventSubscriber\Kernel
 */
class RequestSubscriber implements EventSubscriberInterface
{
    /**
     * @var array|string[]
     */
    private static array $supportedPreferredLanguages = ['en'];

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => [
                ['setLocale', 512],
                ['setRequestContent', 520],
            ],
        ];
    }

    /**
     * @param RequestEvent $event
     */
    public function setLocale(RequestEvent $event): void
    {
        $request = $event->getRequest();
        $preferredLanguage = $request->getPreferredLanguage(self::$supportedPreferredLanguages);
        $request->setLocale($preferredLanguage);
    }

    /**
     * @param RequestEvent $event
     */
    public function setRequestContent(RequestEvent $event): void
    {
        $request = $event->getRequest();

        if (str_starts_with($request->headers->get('Content-Type'), 'application/json')) {
            $data = json_decode($request->getContent(), true);
            $request->request->replace(is_array($data) ? $data : []);
        }
    }
}
