<?php

namespace App\Context\Account\Application\Common\Error;

/**
 * Interface ErrorInterface
 * @package App\Context\Account\Application\Common\Error
 */
interface ErrorInterface
{
    /**
     * @return string
     */
    public function getCode(): string;

    /**
     * @return string
     */
    public function getMessage(): string;
}
