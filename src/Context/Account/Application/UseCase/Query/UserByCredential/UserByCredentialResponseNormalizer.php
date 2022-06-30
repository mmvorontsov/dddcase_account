<?php

namespace App\Context\Account\Application\UseCase\Query\UserByCredential;

use App\Context\Account\Infrastructure\Serialization\SerializerInterface;

/**
 * Class UserByCredentialResponseNormalizer
 * @package App\Context\Account\Application\UseCase\Query\UserByCredential
 */
final class UserByCredentialResponseNormalizer implements UserByCredentialResponseNormalizerInterface
{
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * UserByCredentialResponseNormalizer constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param UserByCredentialResponse $response
     * @return array
     */
    public function toArray(UserByCredentialResponse $response): array
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
