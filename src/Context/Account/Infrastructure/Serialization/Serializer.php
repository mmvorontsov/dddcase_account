<?php

namespace App\Context\Account\Infrastructure\Serialization;

use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface as SymfonySerializerInterface;

/**
 * Class Serializer
 * @package App\Context\Account\Infrastructure\Serialization
 */
final class Serializer implements SerializerInterface
{
    /**
     * @var SymfonySerializerInterface
     */
    private SymfonySerializerInterface $serializer;

    /**
     * Serializer constructor.
     */
    public function __construct()
    {
        $this->serializer = SymfonySerializerFactory::create();
    }

    /**
     * @inheritdoc
     */
    public function serialize($data, $format, array $context = []): string
    {
        return $this->serializer->serialize($data, $format, $context);
    }

    /**
     * @inheritdoc
     */
    public function deserialize($data, $type, $format, array $context = []): mixed
    {
        return $this->serializer->deserialize($data, $type, $format, $context);
    }

    /**
     * @inheritdoc
     * @throws ExceptionInterface
     */
    public function normalize($object, $format = null, array $context = []): mixed
    {
        return $this->serializer->normalize($object, $format, $context);
    }

    /**
     * @inheritdoc
     * @throws ExceptionInterface
     */
    public function denormalize($data, $type, $format = null, array $context = []): mixed
    {
        return $this->serializer->denormalize($data, $type, $format, $context);
    }
}
