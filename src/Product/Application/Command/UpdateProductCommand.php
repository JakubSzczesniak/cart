<?php

/*
 * This file is part of the Symfony 4 CQRS Cart Project.
 *
 * (c) Jakub Szcześniak
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Product\Application\Command;

use App\Shared\Application\Validator\Constraints\EntityExist;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Class UpdateProductCommand
 */
final class UpdateProductCommand
{
    /**
     * @var int
     *
     * @EntityExist("App\Product\Domain\Entity\Product")
     */
    private $productId;

    /**
     * @var string|null
     */
    private $name;

    /**
     * @var int|null
     *
     * @Assert\GreaterThan(0)
     */
    private $price;

    /**
     * UpdateProductCommand constructor.
     *
     * @param int    $productId
     * @param string $name
     * @param int    $price
     */
    public function __construct(int $productId, ?string $name, ?int $price)
    {
        $this->name = $name;
        $this->price = $price;
        $this->productId = $productId;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return int|null
     */
    public function getPrice(): ?int
    {
        return $this->price;
    }

    /**
     * @return int
     */
    public function getProductId(): int
    {
        return $this->productId;
    }
}
