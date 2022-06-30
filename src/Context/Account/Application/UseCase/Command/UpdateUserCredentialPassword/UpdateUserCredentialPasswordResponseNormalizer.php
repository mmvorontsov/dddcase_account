<?php

namespace App\Context\Account\Application\UseCase\Command\UpdateUserCredentialPassword;

use App\Context\Account\Application\UseCase\Command\UpdateUserCredentialPassword\{
    UpdateUserCredentialPasswordResponseNormalizerInterface as UseCaseResponseNormalizerInterface,
};
use App\Context\Account\Infrastructure\Serialization\SerializerInterface;

/**
 * Class UpdateUserCredentialPasswordResponseNormalizer
 * @package App\Context\Account\Application\UseCase\Command\UpdateUserCredentialPassword
 */
final class UpdateUserCredentialPasswordResponseNormalizer implements UseCaseResponseNormalizerInterface
{
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * UpdateUserCredentialPasswordResponseNormalizer constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param UpdateUserCredentialPasswordResponse $response
     * @return array
     */
    public function toArray(UpdateUserCredentialPasswordResponse $response): array
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
