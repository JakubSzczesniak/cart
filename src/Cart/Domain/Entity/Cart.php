<?php

/*
 * This file is part of the Symfony 4 CQRS Cart Project.
 *
 * (c) Jakub Szcześniak
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Cart\Domain\Entity;

use App\Cart\Domain\Event\ProductAddedEvent;
use App\Product\Domain\Entity\Product;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Cart\Infrastructure\Repository\CartRepository")
 */
final class Cart
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var array
     *
     * @ORM\Column(type="json")
     */
    private $products = [];

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $total;

    /**
     * Cart constructor.
     */
    public function __construct()
    {
        $this->total = 0;
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param Product $product
     */
    public function addProduct(Product $product): void
    {
        $this->products[] = $product->getId();
        $this->total += $product->getPrice();
    }

    /**
     * @return array
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    /**
     * @param Product $product
     *
     * @return bool
     */
    public function hasProduct(Product $product): bool
    {
        return in_array($product->getId(), $this->getProducts());
    }

    /**
     * @param Product $product
     */
    public function removeProduct(Product $product): void
    {
        if ($this->hasProduct($product)) {
            unset($this->products[$product->getId()]);
        }
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }
}
