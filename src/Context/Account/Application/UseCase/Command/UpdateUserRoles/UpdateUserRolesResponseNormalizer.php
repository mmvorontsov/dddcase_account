<?php

namespace App\Context\Account\Application\UseCase\Command\UpdateUserRoles;

use App\Context\Account\Infrastructure\Serialization\SerializerInterface;

/**
 * Class UpdateUserRolesResponseNormalizer
 * @package App\Context\Account\Application\UseCase\Command\UpdateUserRoles
 */
final class UpdateUserRolesResponseNormalizer implements UpdateUserRolesResponseNormalizerInterface
{
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * UpdateUserRolesResponseNormalizer constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param UpdateUserRolesResponse $response
     * @return array
     */
    public function toArray(UpdateUserRolesResponse $response): array
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
