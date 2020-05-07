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

    private $events = [];

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
     * @param int $productId
     */
    public function addProduct(int $productId): void
    {
        $this->products[] = $productId;

        $this->events[] = new ProductAddedEvent($this->getId(), $productId);
    }

    /**
     * @return array
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    /**
     * @param int $productId
     */
    public function removeProduct(int $productId): void
    {
        if (($key = array_search($productId, $this->products)) !== false) {
            unset($this->products[$key]);
        }
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @param int $total
     */
    public function setTotal(int $total): void
    {
        $this->total = $total;
    }
}
