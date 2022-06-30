<?php

namespace App\Context\Account\Application\Common\Error\ValidationError;

use App\Context\Account\Application\Common\Error\ErrorInterface;

/**
 * Interface ValidationErrorInterface
 * @package App\Context\Account\Application\Common\Error\ValidationError
 */
interface ValidationErrorInterface extends ErrorInterface
{
    /**
     * @return string
     */
    public function getPath(): string;
}
