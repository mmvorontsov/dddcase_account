<?php

namespace App\Context\Account\Application\UseCase\Query\CredentialRecoveryKeyMaker;

use App\Context\Account\Infrastructure\Serialization\SerializerInterface;

/**
 * Class CredentialRecoveryKeyMakerResponseNormalizer
 * @package App\Context\Account\Application\UseCase\Query\CredentialRecoveryKeyMaker
 */
final class CredentialRecoveryKeyMakerResponseNormalizer implements
    CredentialRecoveryKeyMakerResponseNormalizerInterface
{
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * CredentialRecoveryKeyMakerResponseNormalizer constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param CredentialRecoveryKeyMakerResponse $response
     * @return array
     */
    public function toArray(CredentialRecoveryKeyMakerResponse $response): array
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
