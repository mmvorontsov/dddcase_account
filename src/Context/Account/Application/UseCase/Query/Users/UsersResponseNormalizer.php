<?php

namespace App\Context\Account\Application\UseCase\Query\Users;

use App\Context\Account\Infrastructure\Serialization\SerializerInterface;

/**
 * Class UsersResponseNormalizer
 * @package App\Context\Account\Application\UseCase\Query\Users
 */
final class UsersResponseNormalizer implements UsersResponseNormalizerInterface
{
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * UsersResponseNormalizer constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param UsersResponse $response
     * @return array
     */
    public function toArray(UsersResponse $response): array
    {
        // Use SerializerInterface::ATTRIBUTES and/or SerializerInterface::IGNORE_ATTRIBUTES
        // keys of context to control the normalization process
        $context = [
            SerializerInterface::ATTRIBUTES => [
                'pagination',
                'items',
            ]
        ];

        return $this->serializer->normalize($response, context: $context);
    }
}
