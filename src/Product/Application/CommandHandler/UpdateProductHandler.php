<?php

/*
 * This file is part of the Symfony 4 CQRS Cart Project.
 *
 * (c) Jakub Szcześniak
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Product\Application\CommandHandler;

use App\Product\Application\Command\UpdateProductCommand;
use App\Product\Domain\Entity\Product;
use App\Product\Domain\Repository\ProductRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * Class UpdateProductHandler
 */
final class UpdateProductHandler implements MessageHandlerInterface
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * UpdateProductHandler constructor.
     *
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @param UpdateProductCommand $command
     */
    public function __invoke(UpdateProductCommand $command)
    {
        /** @var Product $product */
        $product = $this->productRepository->find($command->getProductId());

        if (null !== $command->getPrice()) {
            $product->setPrice($command->getPrice());
        }

        if (null !== $command->getName()) {
            $product->setName($command->getName());
        }

        $this->productRepository->add($product);
    }
}
