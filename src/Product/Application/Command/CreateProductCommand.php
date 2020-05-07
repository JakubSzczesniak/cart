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

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class CreateProductCommand
 */
final class CreateProductCommand
{
    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Length(min=5, max=100)
     */
    private $name;

    /**
     * @var int
     *
     * @Assert\NotBlank()
     * @Assert\GreaterThan(0)
     */
    private $price;

    /**
     * CreateProductCommand constructor.
     *
     * @param string $name
     * @param int    $price
     */
    public function __construct(string $name, int $price)
    {
        $this->name = $name;
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }
}
