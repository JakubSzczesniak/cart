<?php

/*
 * This file is part of the Symfony 4 CQRS Cart Project.
 *
 * (c) Jakub Szcześniak
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Cart\Application\Command;

use App\Shared\Application\Validator\Constraints\EntityExist;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class AddProductCommand
 */
final class AddProductCommand
{
    /**
     * @var int
     *
     * @Assert\NotBlank()
     * @EntityExist("App\Cart\Domain\Entity\Cart")
     */
    private $cartId;

    /**
     * @var int
     *
     * @Assert\NotBlank()
     * @EntityExist("App\Product\Domain\Entity\Product")
     */
    private $productId;

    /**
     * AddProductCommand constructor.
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
