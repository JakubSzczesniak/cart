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

use App\Cart\Application\Command\AddProductCommand;
use App\Cart\Domain\Entity\Cart;
use App\Cart\Domain\Repository\CartRepositoryInterface;
use App\Product\Domain\Entity\Product;
use App\Product\Domain\Repository\ProductRepositoryInterface;
use Exception;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * Class AddProductHandler
 */
final class AddProductHandler implements MessageHandlerInterface
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
     * AddProductHandler constructor.
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
     * @param AddProductCommand $command
     *
     * @throws Exception
     */
    public function __invoke(AddProductCommand $command)
    {
        /** @var Cart $cart */
        $cart = $this->cartRepository->find($command->getCartId());

        /** @var Product $product */
        $product = $this->productRepository->find($command->getCartId());

        $cart->addProduct($command->getProductId());
        $cart->setTotal($cart->getTotal() + $product->getPrice());

        $this->cartRepository->update($cart);
    }
}
