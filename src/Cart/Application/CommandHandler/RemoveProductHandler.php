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
use App\Product\Domain\Entity\Product;
use App\Product\Domain\Repository\ProductRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * Class RemoveProductHandler
 */
final class RemoveProductHandler implements MessageHandlerInterface
{
    /**
     * @var CartRepositoryInterface
     */
    private $cartRepository;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * RemoveProductHandler constructor.
     *
     * @param CartRepositoryInterface    $cartRepository
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(CartRepositoryInterface $cartRepository, ProductRepositoryInterface $productRepository)
    {
        $this->cartRepository = $cartRepository;
        $this->productRepository = $productRepository;
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

        /** @var Product $product */
        $product = $this->productRepository->find($command->getProductId());

        if (!$cart->hasProduct($product)) {
            throw new ProductNotFoundException(sprintf('Product id: %s does not in cart', $command->getProductId()));
        }

        $cart->removeProduct($product);

        $this->cartRepository->add($cart);
    }
}
