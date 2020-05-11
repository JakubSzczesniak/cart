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

use App\Product\Application\Command\CreateProductCommand;
use App\Product\Application\Command\UpdateProductCommand;
use App\Shared\Infrastructure\ValidationHelper;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\ValidationFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UpdateProductController
 */
final class UpdateProductController extends AbstractController
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
     * UpdateProductController constructor.
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
     * Remove product from cart
     *
     * @Route("/products/{productId}", methods={"PATCH"}, name="update_product")
     *
     * @param int     $productId
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function updateProduct(int $productId, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $command = new UpdateProductCommand($productId, $data['name'] ?? null, $data['price'] ?? null);

        try {
            $this->commandBus->dispatch($command);
        } catch (ValidationFailedException $exception) {
            $validationHelper = new ValidationHelper($exception->getViolations());

            return new JsonResponse($validationHelper->getErrors(), Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
