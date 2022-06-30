<?php

namespace App\Context\Account\Application\UseCase\Command\CreateCredentialRecovery;

use App\Context\Account\Infrastructure\Serialization\SerializerInterface;

/**
 * Class CreateCredentialRecoveryResponseNormalizer
 * @package App\Context\Account\Application\UseCase\Command\CreateCredentialRecovery
 */
final class CreateCredentialRecoveryResponseNormalizer implements
    CreateCredentialRecoveryResponseNormalizerInterface
{
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * CreateCredentialRecoveryResponseNormalizer constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param CreateCredentialRecoveryResponse $response
     * @return array
     */
    public function toArray(CreateCredentialRecoveryResponse $response): array
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
