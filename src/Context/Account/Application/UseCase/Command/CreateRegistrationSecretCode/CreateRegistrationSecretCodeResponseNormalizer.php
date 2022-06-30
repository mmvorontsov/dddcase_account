<?php

namespace App\Context\Account\Application\UseCase\Command\CreateRegistrationSecretCode;

use App\Context\Account\Infrastructure\Serialization\SerializerInterface;

/**
 * Class CreateRegistrationSecretCodeResponseNormalizer
 * @package App\Context\Account\Application\UseCase\Command\CreateRegistrationSecretCode
 */
final class CreateRegistrationSecretCodeResponseNormalizer implements
    CreateRegistrationSecretCodeResponseNormalizerInterface
{
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * CreateRegistrationSecretCodeResponseNormalizer constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param CreateRegistrationSecretCodeResponse $response
     * @return array
     */
    public function toArray(CreateRegistrationSecretCodeResponse $response): array
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
