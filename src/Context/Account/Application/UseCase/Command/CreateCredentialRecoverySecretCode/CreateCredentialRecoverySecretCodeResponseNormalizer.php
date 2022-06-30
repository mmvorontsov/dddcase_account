<?php

namespace App\Context\Account\Application\UseCase\Command\CreateCredentialRecoverySecretCode;

use App\Context\Account\Infrastructure\Serialization\SerializerInterface;

/**
 * Class CreateCredentialRecoverySecretCodeResponseNormalizer
 * @package App\Context\Account\Application\UseCase\Command\CreateCredentialRecoverySecretCode
 */
final class CreateCredentialRecoverySecretCodeResponseNormalizer implements
    CreateCredentialRecoverySecretCodeResponseNormalizerInterface
{
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * CreateCredentialRecoverySecretCodeResponseNormalizer constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param CreateCredentialRecoverySecretCodeResponse $response
     * @return array
     */
    public function toArray(CreateCredentialRecoverySecretCodeResponse $response): array
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
