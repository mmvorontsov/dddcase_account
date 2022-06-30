<?php

namespace App\Context\Account\Application\Common\Pagination;

use Iterator;
use IteratorAggregate;
use Traversable;

/**
 * Class Pagination
 * @package App\Context\Account\Application\Common\Pagination
 */
final class Pagination implements IteratorAggregate
{
    /**
     * @var int
     */
    private int $page;

    /**
     * @var int
     */
    private int $limit;

    /**
     * @var int
     */
    private int $count;

    /**
     * @var Iterator
     */
    private Iterator $iterator;

    /**
     * Pagination constructor.
     * @param int $page
     * @param int $limit
     * @param int $count
     * @param Iterator $iterator
     */
    public function __construct(int $page, int $limit, int $count, Iterator $iterator)
    {
        $this->page = $page;
        $this->limit = $limit;
        $this->count = $count;
        $this->iterator = $iterator;
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @return Iterator|Traversable
     */
    public function getIterator(): Traversable|Iterator
    {
        return $this->iterator;
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }
}
