<?php

namespace App\Context\Account\Application\UseCase\Command\UpdateUser;

use App\Context\Account\Infrastructure\Serialization\SerializerInterface;

/**
 * Class UpdateUserResponseNormalizer
 * @package App\Context\Account\Application\UseCase\Command\UpdateUser
 */
final class UpdateUserResponseNormalizer implements UpdateUserResponseNormalizerInterface
{
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * UpdateUserResponseNormalizer constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param UpdateUserResponse $response
     * @return array
     */
    public function toArray(UpdateUserResponse $response): array
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
