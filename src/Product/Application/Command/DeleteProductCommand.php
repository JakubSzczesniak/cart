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
 * Class DeleteProductCommand
 */
final class DeleteProductCommand
{
    /**
     * @var int
     *
     * @Assert\NotBlank()
     * @EntityExist("App\Product\Domain\Entity\Product")
     */
    private $productId;

    /**
     * DeleteProductCommand constructor.
     *
     * @param int $productId
     */
    public function __construct(int $productId)
    {
        $this->productId = $productId;
    }

    /**
     * @return int
     */
    public function getProductId(): int
    {
        return $this->productId;
    }
}
