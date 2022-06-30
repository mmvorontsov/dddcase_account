<?php

namespace App\Context\Account\Application\UseCase\Query\ContactDataChangeKeyMaker;

use App\Context\Account\Infrastructure\Serialization\SerializerInterface;

/**
 * Class ContactDataChangeKeyMakerResponseNormalizer
 * @package App\Context\Account\Application\UseCase\Query\ContactDataChangeKeyMaker
 */
final class ContactDataChangeKeyMakerResponseNormalizer implements
    ContactDataChangeKeyMakerResponseNormalizerInterface
{
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * ContactDataChangeKeyMakerResponseNormalizer constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param ContactDataChangeKeyMakerResponse $response
     * @return array
     */
    public function toArray(ContactDataChangeKeyMakerResponse $response): array
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
