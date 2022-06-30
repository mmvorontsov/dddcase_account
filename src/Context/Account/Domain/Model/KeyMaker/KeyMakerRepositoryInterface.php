<?php

namespace App\Context\Account\Domain\Model\KeyMaker;

/**
 * Interface KeyMakerRepositoryInterface
 * @package App\Context\Account\Domain\Model\KeyMaker
 */
interface KeyMakerRepositoryInterface
{
    /**
     * @param KeyMaker $keyMaker
     */
    public function add(KeyMaker $keyMaker): void;

    /**
     * @param KeyMaker $keyMaker
     */
    public function remove(KeyMaker $keyMaker): void;

    /**
     * @param KeyMakerId $keyMakerId
     * @return KeyMaker|null
     */
    public function findById(KeyMakerId $keyMakerId): ?KeyMaker;

    /**
     * @param KeyMakerSelectionSpecInterface $spec
     * @return KeyMaker|null
     */
    public function selectOneSatisfying(KeyMakerSelectionSpecInterface $spec): ?KeyMaker;
}
