<?php

namespace App\Context\Account\Application\UseCase\Query\RegistrationKeyMaker;

use App\Context\Account\Infrastructure\Serialization\SerializerInterface;

/**
 * Class RegistrationKeyMakerResponseNormalizer
 * @package App\Context\Account\Application\UseCase\Query\RegistrationKeyMaker
 */
final class RegistrationKeyMakerResponseNormalizer implements
    RegistrationKeyMakerResponseNormalizerInterface
{
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * RegistrationKeyMakerResponseNormalizer constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param RegistrationKeyMakerResponse $response
     * @return array
     */
    public function toArray(RegistrationKeyMakerResponse $response): array
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
