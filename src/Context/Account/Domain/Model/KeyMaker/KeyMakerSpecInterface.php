<?php

namespace App\Context\Account\Domain\Model\KeyMaker;

use App\Context\Account\Domain\Model\SpecInterface;

/**
 * Interface KeyMakerSpecInterface
 * @package App\Context\Account\Domain\Model\KeyMaker
 */
interface KeyMakerSpecInterface extends SpecInterface
{
    /**
     * @param KeyMaker $keyMaker
     * @return bool
     */
    public function isSatisfiedBy(KeyMaker $keyMaker): bool;
}
