<?php

/*
 * This file is part of the Symfony 4 CQRS Cart Project.
 *
 * (c) Jakub Szcześniak
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Cart\Application\Query;

/**
 * Class GetContentsQuery
 */
final class GetContentsQuery
{
    /**
     * @var int
     */
    private $limit;

    /**
     * @var int
     */
    private $offset;

    /**
     * @var int
     */
    private $cartId;

    /**
     * GetContentsQuery constructor.
     *
     * @param int $cartId
     * @param int $limit
     * @param int $offset
     */
    public function __construct(int $cartId, int $limit, int $offset)
    {
        $this->limit = $limit;
        $this->offset = $offset;
        $this->cartId = $cartId;
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
    public function getOffset(): int
    {
        return $this->offset;
    }

    /**
     * @return int
     */
    public function getCartId(): int
    {
        return $this->cartId;
    }
}
