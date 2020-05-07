<?php

/*
 * This file is part of the Symfony 4 CQRS Cart Project.
 *
 * (c) Jakub Szcześniak
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Cart\Application\QueryHandler;

use App\Cart\Application\View\CartView;
use App\Cart\Application\Query\GetContentsQuery;
use App\Cart\Domain\Entity\Cart;
use App\Cart\Domain\Repository\CartRepositoryInterface;
use App\Cart\Infrastructure\Repository\CartRepository;
use App\Product\Domain\Entity\Product;
use App\Product\Domain\Repository\ProductRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * Class GetContentsHandler
 */
final class GetContentsHandler implements MessageHandlerInterface
{
    /**
     * @var CartRepository
     */
    private $cartRepository;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * GetContentsHandler constructor.
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
     * @param GetContentsQuery $query
     *
     * @return CartView
     */
    public function __invoke(GetContentsQuery $query): CartView
    {
        /** @var Cart $cart */
        $cart = $this->cartRepository->find($query->getCartId());

        $products = [];
        /** @var int $productId */
        foreach ($cart->getProducts() as $productId) {
            /** @var Product $product */
            $product =  $this->productRepository->find($productId);
            $products[] = [
                'name' => $product->getName(),
                'price' => $product->getPrice(),
            ];
        }

        return new CartView($cart->getId(), $cart->getTotal(), $products);
    }
}
