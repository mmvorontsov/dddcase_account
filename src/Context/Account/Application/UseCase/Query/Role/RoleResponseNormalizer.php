<?php

namespace App\Context\Account\Application\UseCase\Query\Role;

use App\Context\Account\Infrastructure\Serialization\SerializerInterface;

/**
 * Class RoleResponseNormalizer
 * @package App\Context\Account\Application\UseCase\Query\Role
 */
final class RoleResponseNormalizer implements RoleResponseNormalizerInterface
{
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * RoleResponseNormalizer constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param RoleResponse $response
     * @return array
     */
    public function toArray(RoleResponse $response): array
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
