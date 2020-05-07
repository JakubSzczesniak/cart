<?php

/*
 * This file is part of the Symfony 4 CQRS Cart Project.
 *
 * (c) Jakub Szcześniak
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Shared\Domain;

/**
 * Class Paginator
 */
class Paginator
{
    public const PAGE_SIZE = 3;

    /**
     * @var float|int
     */
    private $offset;

    /**
     * @var int
     */
    private $limit;

    /**
     * @var int
     */
    private $pageNumber;

    /**
     * Paginator constructor.
     *
     * @param int $pageNumber
     */
    public function __construct(int $pageNumber)
    {
        $pageNumber = (int)$pageNumber - 1;

        if ($pageNumber < 0) {
            $pageNumber = 0;
        }

        $this->pageNumber = $pageNumber + 1;
        $this->limit = self::PAGE_SIZE;
        $this->offset = $pageNumber * self::PAGE_SIZE;
    }

    /**
     * @return float|int
     */
    public function getOffset()
    {
        return $this->offset;
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
    public function getPageNumber(): int
    {
        return $this->pageNumber;
    }
}
