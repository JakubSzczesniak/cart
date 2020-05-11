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

use App\Product\Application\Command\DeleteProductCommand;
use App\Product\Domain\Entity\Product;
use App\Product\Domain\Repository\ProductRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * Class DeleteProductHandler
 */
final class DeleteProductHandler implements MessageHandlerInterface
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * DeleteProductHandler constructor.
     *
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @param DeleteProductCommand $command
     */
    public function __invoke(DeleteProductCommand $command)
    {
        /** @var Product $product */
        $product = $this->productRepository->find($command->getProductId());

        $this->productRepository->remove($product);
    }
}
