<?php

declare(strict_types = 1);

/*
 * This file is part of the Symfony 4 CQRS Cart Project.
 *
 * (c) Jakub Szcześniak
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Product\Infrastructure\Api;

use App\Product\Application\Command\DeleteProductCommand;
use App\Shared\Infrastructure\ValidationHelper;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\ValidationFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DeleteProductController
 */
final class DeleteProductController extends AbstractController
{
    /**
     * @var MessageBusInterface
     */
    private $commandBus;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * DeleteProductController constructor.
     *
     * @param MessageBusInterface $commandBus
     * @param LoggerInterface     $logger
     */
    public function __construct(MessageBusInterface $commandBus, LoggerInterface $logger)
    {
        $this->commandBus = $commandBus;
        $this->logger = $logger;
    }

    /**
     * Delete product
     *
     * @Route("/products/{productId}", methods={"DELETE"}, name="delete_product")
     *
     * @param int $productId
     *
     * @return JsonResponse
     */
    public function removeProduct(int $productId): JsonResponse
    {
        $command = new DeleteProductCommand($productId);

        try {
            $this->commandBus->dispatch($command);
        } catch (ValidationFailedException $exception) {
            $validationHelper = new ValidationHelper($exception->getViolations());

            return new JsonResponse($validationHelper->getErrors(), Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
