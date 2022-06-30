<?php

namespace App\Context\Account\Application\UseCase\Assembly\Output\Meta;

use App\Context\Account\Application\Common\Pagination\Pagination;

use function ceil;

/**
 * Class PaginationDto
 * @package App\Context\Account\Application\UseCase\Assembly\Output\Meta
 */
final class PaginationDto
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
     * @var int
     */
    private int $pages;

    /**
     * PaginationDto constructor.
     * @param int $page
     * @param int $limit
     * @param int $count
     */
    public function __construct(int $page, int $limit, int $count)
    {
        $this->page = $page;
        $this->limit = $limit;
        $this->count = $count;
        $this->pages = ceil($count / $limit);
    }

    /**
     * @param Pagination $pagination
     * @return static
     */
    public static function createFromPagination(Pagination $pagination): self
    {
        return new self(
            $pagination->getPage(),
            $pagination->getLimit(),
            $pagination->getCount(),
        );
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

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @return int
     */
    public function getPages(): int
    {
        return $this->pages;
    }
}
