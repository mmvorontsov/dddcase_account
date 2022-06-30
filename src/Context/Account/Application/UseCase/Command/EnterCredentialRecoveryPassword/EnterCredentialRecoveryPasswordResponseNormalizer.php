<?php

namespace App\Context\Account\Application\UseCase\Command\EnterCredentialRecoveryPassword;

use App\Context\Account\Infrastructure\Serialization\SerializerInterface;

/**
 * Class EnterCredentialRecoveryPasswordResponseNormalizer
 * @package App\Context\Account\Application\UseCase\Command\EnterCredentialRecoveryPassword
 */
final class EnterCredentialRecoveryPasswordResponseNormalizer implements
    EnterCredentialRecoveryPasswordResponseNormalizerInterface
{
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * EnterCredentialRecoveryPasswordResponseNormalizer constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param EnterCredentialRecoveryPasswordResponse $response
     * @return array
     */
    public function toArray(EnterCredentialRecoveryPasswordResponse $response): array
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
