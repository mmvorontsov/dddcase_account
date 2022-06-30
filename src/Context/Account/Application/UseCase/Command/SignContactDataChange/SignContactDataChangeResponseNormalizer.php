<?php

namespace App\Context\Account\Application\UseCase\Command\SignContactDataChange;

use App\Context\Account\Infrastructure\Serialization\SerializerInterface;

/**
 * Class SignContactDataChangeResponseNormalizer
 * @package App\Context\Account\Application\UseCase\Command\SignContactDataChange
 */
final class SignContactDataChangeResponseNormalizer implements SignContactDataChangeResponseNormalizerInterface
{
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * SignContactDataChangeResponseNormalizer constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param SignContactDataChangeResponse $response
     * @return array
     */
    public function toArray(SignContactDataChangeResponse $response): array
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
