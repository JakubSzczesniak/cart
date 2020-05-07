<?php

/*
 * This file is part of the Symfony 4 CQRS Cart Project.
 *
 * (c) Jakub Szcześniak
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Product\Domain\Repository;

use App\Product\Domain\Entity\Product;
use Doctrine\Persistence\ObjectRepository;

/**
 * Interface ProductRepositoryInterface
 */
interface ProductRepositoryInterface extends ObjectRepository
{
    /**
     * @param Product $product
     *
     * @return bool
     */
    public function exists(Product $product): bool;

    /**
     * @param Product $product
     */
    public function add(Product $product): void;

    /**
     * @param Product $product
     */
    public function remove(Product $product): void;

    /**
     * @param Product $product
     */
    public function update(Product $product): void;
}
