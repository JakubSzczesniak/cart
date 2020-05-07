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

use App\Cart\Application\Command\RemoveProductCommand;
use App\Cart\Application\Exception\ProductNotFoundException;
use App\Cart\Domain\Entity\Cart;
use App\Cart\Domain\Repository\CartRepositoryInterface;
use App\Cart\Infrastructure\Repository\CartRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * Class RemoveProductHandler
 */
final class RemoveProductHandler implements MessageHandlerInterface
{
    /**
     * @var CartRepository
     */
    private $cartRepository;

    /**
     * RemoveProductHandler constructor.
     *
     * @param CartRepositoryInterface $cartRepository
     */
    public function __construct(CartRepositoryInterface $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    /**
     * @param RemoveProductCommand $command
     *
     * @throws ProductNotFoundException
     */
    public function __invoke(RemoveProductCommand $command)
    {
        /** @var Cart $cart */
        $cart = $this->cartRepository->find($command->getCartId());

        if (!in_array($command->getProductId(), $cart->getProducts())) {
            throw new ProductNotFoundException(sprintf('Product id: %s does not in cart', $command->getProductId()));
            //todo czy to dobrze, ze  taki wyjatek rzucam? Co jak bedzie 100 pol w endpoincie? mam zlapac w kontrolerze 100 wyjatkow?
        }

        $cart->removeProduct($command->getProductId());

        $this->cartRepository->update($cart);
    }
}
