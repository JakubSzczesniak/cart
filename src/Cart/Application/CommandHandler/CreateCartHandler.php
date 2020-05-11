<?php

/*
 * This file is part of the Symfony 4 CQRS Cart Project.
 *
 * (c) Jakub Szcześniak
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Cart\Application\CommandHandler;

use App\Cart\Domain\Entity\Cart;
use App\Cart\Domain\Repository\CartRepositoryInterface;
use App\Cart\Application\Command\CreateCartCommand;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * Class CreateCartHandler
 */
final class CreateCartHandler implements MessageHandlerInterface
{
    /**
     * @var CartRepositoryInterface
     */
    private $cartRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * CreateCartHandler constructor.
     *
     * @param CartRepositoryInterface $cartRepository
     * @param EntityManagerInterface  $entityManager
     */
    public function __construct(CartRepositoryInterface $cartRepository, EntityManagerInterface $entityManager)
    {
        $this->cartRepository = $cartRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @param CreateCartCommand $command
     *
     * @return int
     */
    public function __invoke(CreateCartCommand $command): int
    {
        $cart = new Cart();
        $this->cartRepository->add($cart);

        return $cart->getId();
    }
}
