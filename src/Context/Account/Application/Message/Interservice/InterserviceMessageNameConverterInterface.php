<?php

namespace App\Context\Account\Application\Message\Interservice;

/**
 * Interface InterserviceMessageNameConverterInterface
 * @package App\Context\Account\Application\Message\Interservice
 */
interface InterserviceMessageNameConverterInterface
{
    /**
     * @param string $class
     * @return string
     */
    public function normalize(string $class): string;

    /**
     * @param string $type
     * @return string
     */
    public function denormalize(string $type): string;
}
