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

use App\Product\Application\Command\CreateProductCommand;
use App\Product\Domain\Entity\Product;
use App\Product\Domain\Repository\ProductRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * Class CreateProductHandler
 */
final class CreateProductHandler implements MessageHandlerInterface
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * CreateProductHandler constructor.
     *
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @param CreateProductCommand $command
     */
    public function __invoke(CreateProductCommand $command)
    {
        $product = new Product($command->getName(), $command->getPrice());

        $this->productRepository->add($product);
    }
}
