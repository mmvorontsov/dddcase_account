<?php

namespace App\Context\Account\Infrastructure\Templating\Twig\Context\Email;

use Twig\Error\LoaderError;

/**
 * Interface EmailContextInterface
 * @package App\Context\Account\Infrastructure\Templating\Twig\Context\Email
 */
interface EmailContextInterface
{
    /**
     * @param string $image
     * @param string|null $contentType
     * @return string
     * @throws LoaderError
     */
    public function image(string $image, ?string $contentType = null): string;
}
