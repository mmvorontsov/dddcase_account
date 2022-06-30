<?php

namespace App\Context\Account\Application\UseCase\Command\SignRegistration;

use App\Context\Account\Infrastructure\Serialization\SerializerInterface;

/**
 * Class SignRegistrationResponseNormalizer
 * @package App\Context\Account\Application\UseCase\Command\SignRegistration
 */
final class SignRegistrationResponseNormalizer implements SignRegistrationResponseNormalizerInterface
{
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * SignRegistrationResponseNormalizer constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param SignRegistrationResponse $response
     * @return array
     */
    public function toArray(SignRegistrationResponse $response): array
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
