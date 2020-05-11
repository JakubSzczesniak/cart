<?php

/*
 * This file is part of the Symfony 4 CQRS Cart Project.
 *
 * (c) Jakub Szcześniak
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Cart\Domain\Event;

use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class ProductRemovedEvent
 */
final class ProductRemovedEvent extends Event
{
    /**
     * @var int
     */
    private $cartId;

    /**
     * @var int
     */
    private $productId;

    /**
     * ProductRemovedEvent constructor.
     *
     * @param int $cartId
     * @param int $productId
     */
    public function __construct(int $cartId, int $productId)
    {
        $this->cartId = $cartId;
        $this->productId = $productId;
    }

    /**
     * @return int
     */
    public function getCartId(): int
    {
        return $this->cartId;
    }

    /**
     * @return int
     */
    public function getProductId(): int
    {
        return $this->productId;
    }
}
