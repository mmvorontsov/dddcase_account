<?php

namespace App\Context\Account\Application\UseCase\Command\CreateRegistration;

use App\Context\Account\Infrastructure\Serialization\SerializerInterface;

/**
 * Class CreateRegistrationResponseNormalizer
 * @package App\Context\Account\Application\UseCase\Command\CreateRegistration
 */
final class CreateRegistrationResponseNormalizer implements CreateRegistrationResponseNormalizerInterface
{
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * CreateRegistrationResponseNormalizer constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param CreateRegistrationResponse $response
     * @return array
     */
    public function toArray(CreateRegistrationResponse $response): array
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
