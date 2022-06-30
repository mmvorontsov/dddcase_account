<?php

namespace App\Context\Account\Application\UseCase\Query\UserContactData;

use App\Context\Account\Infrastructure\Serialization\SerializerInterface;

/**
 * Class UserContactDataResponseNormalizer
 * @package App\Context\Account\Application\UseCase\Query\UserContactData
 */
final class UserContactDataResponseNormalizer implements UserContactDataResponseNormalizerInterface
{
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * UserContactDataResponseNormalizer constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param UserContactDataResponse $response
     * @return array
     */
    public function toArray(UserContactDataResponse $response): array
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
