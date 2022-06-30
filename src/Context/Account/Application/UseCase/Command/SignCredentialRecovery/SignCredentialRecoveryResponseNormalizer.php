<?php

namespace App\Context\Account\Application\UseCase\Command\SignCredentialRecovery;

use App\Context\Account\Infrastructure\Serialization\SerializerInterface;

/**
 * Class SignCredentialRecoveryResponseNormalizer
 * @package App\Context\Account\Application\UseCase\Command\SignCredentialRecovery
 */
final class SignCredentialRecoveryResponseNormalizer implements SignCredentialRecoveryResponseNormalizerInterface
{
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * SignCredentialRecoveryResponseNormalizer constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param SignCredentialRecoveryResponse $response
     * @return array
     */
    public function toArray(SignCredentialRecoveryResponse $response): array
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
