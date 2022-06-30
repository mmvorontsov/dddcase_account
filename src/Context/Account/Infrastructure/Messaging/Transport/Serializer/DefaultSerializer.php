<?php

namespace App\Context\Account\Infrastructure\Messaging\Transport\Serializer;

use App\Context\Account\Infrastructure\Serialization\SymfonySerializerFactory;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\Serialization\Serializer as MessengerSerializer;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface as MessengerSerializerInterface;

/**
 * Class DefaultSerializer
 * @package App\Context\Account\Infrastructure\Messaging\Transport\Serializer
 */
final class DefaultSerializer implements MessengerSerializerInterface
{
    /**
     * @var MessengerSerializerInterface
     */
    private MessengerSerializerInterface $serializer;

    /**
     * DefaultSerializer constructor.
     */
    public function __construct()
    {
        // Used customized serializer
        $symfonySerializer = SymfonySerializerFactory::create();
        $this->serializer = new MessengerSerializer($symfonySerializer);
    }

    /**
     * @param array $encodedEnvelope
     * @return Envelope
     */
    public function decode(array $encodedEnvelope): Envelope
    {
        return $this->serializer->decode($encodedEnvelope);
    }

    /**
     * @param Envelope $envelope
     * @return array
     */
    public function encode(Envelope $envelope): array
    {
        return $this->serializer->encode($envelope);
    }
}
