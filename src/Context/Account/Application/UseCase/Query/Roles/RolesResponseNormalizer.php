<?php

namespace App\Context\Account\Application\UseCase\Query\Roles;

use App\Context\Account\Infrastructure\Serialization\SerializerInterface;

/**
 * Class RolesResponseNormalizer
 * @package App\Context\Account\Application\UseCase\Query\Roles
 */
final class RolesResponseNormalizer implements RolesResponseNormalizerInterface
{
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * RolesResponseNormalizer constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param RolesResponse $response
     * @return array
     */
    public function toArray(RolesResponse $response): array
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
