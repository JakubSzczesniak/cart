<?php

/*
 * This file is part of the Symfony 4 CQRS Cart Project.
 *
 * (c) Jakub Szcześniak
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Cart\Domain\Repository;

use App\Cart\Domain\Entity\Cart;
use Doctrine\Persistence\ObjectRepository;

/**
 * Interface CartRepositoryInterface
 */
interface CartRepositoryInterface extends ObjectRepository
{
    /**
     * @param Cart $cart
     *
     * @return bool
     */
    public function exists(Cart $cart): bool;

    /**
     * @param Cart $cart
     */
    public function add(Cart $cart): void;

    /**
     * @param Cart $cart
     */
    public function remove(Cart $cart): void;
}
