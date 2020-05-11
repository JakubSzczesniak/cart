<?php

/*
 * This file is part of the Symfony 4 CQRS Cart Project.
 *
 * (c) Jakub Szcześniak
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Cart\Application\View;

use App\Shared\Application\View\AbstractView;

/**
 * Class CartView
 */
final class CartView extends AbstractView
{
    /**
     * @var int
     */
    protected $id; //todo czy przy finalowej klasie protected nie jest bulszitem? Ewentualnie czy nie usunac final i wtedy moznaby dziedziczyc widoki ale czy to dobre?

    /**
     * @var int
     */
    protected $total;

    /**
     * @var array
     */
    protected $products;

    /**
     * CartView constructor.
     *
     * @param int   $id
     * @param int   $total
     * @param array $products
     */
    public function __construct(int $id, int $total, array $products)
    {
        $this->id = $id;
        $this->total = $total;
        $this->products = $products;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @return array
     */
    public function getProducts(): array
    {
        return $this->products;
    }
}
