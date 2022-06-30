<?php

namespace App\Context\Account\Application\UseCase\Command\CreateContactDataChange;

use App\Context\Account\Infrastructure\Serialization\SerializerInterface;

/**
 * Class CreateContactDataChangeResponseNormalizer
 * @package App\Context\Account\Application\UseCase\Command\CreateContactDataChange
 */
final class CreateContactDataChangeResponseNormalizer implements
    CreateContactDataChangeResponseNormalizerInterface
{
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * CreateContactDataChangeResponseNormalizer constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param CreateContactDataChangeResponse $response
     * @return array
     */
    public function toArray(CreateContactDataChangeResponse $response): array
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
