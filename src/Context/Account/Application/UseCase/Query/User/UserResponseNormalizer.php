<?php

namespace App\Context\Account\Application\UseCase\Query\User;

use App\Context\Account\Infrastructure\Serialization\SerializerInterface;

/**
 * Class UserResponseNormalizer
 * @package App\Context\Account\Application\UseCase\Query\User
 */
final class UserResponseNormalizer implements UserResponseNormalizerInterface
{
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * UserResponseNormalizer constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param UserResponse $response
     * @return array
     */
    public function toArray(UserResponse $response): array
    {
        // Use SerializerInterface::ATTRIBUTES and/or SerializerInterface::IGNORE_ATTRIBUTES
        // keys of context to control the normalization process
        $context = [
            SerializerInterface::ATTRIBUTES => [
                'item',
            ]
        ];

        return $this->serializer->normalize($response, context: $context);
    }
}
