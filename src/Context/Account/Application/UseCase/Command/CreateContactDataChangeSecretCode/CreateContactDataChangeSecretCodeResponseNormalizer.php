<?php

namespace App\Context\Account\Application\UseCase\Command\CreateContactDataChangeSecretCode;

use App\Context\Account\Infrastructure\Serialization\SerializerInterface;

/**
 * Class CreateContactDataChangeSecretCodeResponseNormalizer
 * @package App\Context\Account\Application\UseCase\Command\CreateContactDataChangeSecretCode
 */
final class CreateContactDataChangeSecretCodeResponseNormalizer implements
    CreateContactDataChangeSecretCodeResponseNormalizerInterface
{
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * CreateContactDataChangeSecretCodeResponseNormalizer constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param CreateContactDataChangeSecretCodeResponse $response
     * @return array
     */
    public function toArray(CreateContactDataChangeSecretCodeResponse $response): array
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
