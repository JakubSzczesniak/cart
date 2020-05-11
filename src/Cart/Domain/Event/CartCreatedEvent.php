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
 * Class CartCreatedEvent
 */
final class CartCreatedEvent extends Event
{
    /**
     * @var int
     */
    private $id;

    /**
     * CartCreatedEvent constructor.
     *
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId(): string
    {
        return $this->id;
    }
}
