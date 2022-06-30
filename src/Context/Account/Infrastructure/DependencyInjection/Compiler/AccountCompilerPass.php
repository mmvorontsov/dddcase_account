<?php

namespace App\Context\Account\Infrastructure\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class AccountCompilerPass
 * @package App\Context\Account\Infrastructure\DependencyInjection\Compiler
 */
final class AccountCompilerPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container): void
    {
        //
    }
}
