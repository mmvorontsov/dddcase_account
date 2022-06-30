<?php

namespace App\Context\Account\Application\UseCase\Query\UserCredential;

use App\Context\Account\Infrastructure\Serialization\SerializerInterface;

/**
 * Class UserCredentialResponseNormalizer
 * @package App\Context\Account\Application\UseCase\Query\UserCredential
 */
final class UserCredentialResponseNormalizer implements UserCredentialResponseNormalizerInterface
{
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * UserCredentialResponseNormalizer constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param UserCredentialResponse $response
     * @return array
     */
    public function toArray(UserCredentialResponse $response): array
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
