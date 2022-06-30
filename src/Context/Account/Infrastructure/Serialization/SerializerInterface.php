<?php

namespace App\Context\Account\Infrastructure\Serialization;

/**
 * Interface SerializerInterface
 * @package App\Context\Account\Infrastructure\Serialization
 */
interface SerializerInterface
{
    public const JSON_FORMAT = 'json';
    public const ATTRIBUTES = 'attributes';
    public const CALLBACKS = 'callbacks';
    public const IGNORED_ATTRIBUTES = 'ignored_attributes';

    /**
     * @param $data
     * @param $format
     * @param array $context
     * @return string
     */
    public function serialize($data, $format, array $context = []): string;

    /**
     * @param $data
     * @param $type
     * @param $format
     * @param array $context
     * @return mixed
     */
    public function deserialize($data, $type, $format, array $context = []): mixed;

    /**
     * @param $object
     * @param null $format
     * @param array $context
     * @return mixed
     */
    public function normalize($object, $format = null, array $context = []): mixed;

    /**
     * @param $data
     * @param $type
     * @param null $format
     * @param array $context
     * @return mixed
     */
    public function denormalize($data, $type, $format = null, array $context = []): mixed;
}
