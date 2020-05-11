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

namespace App\Cart\Infrastructure\Api;

use App\Cart\Application\Command\RemoveProductCommand;
use App\Cart\Application\Exception\ProductNotFoundException;
use App\Shared\Infrastructure\ValidationHelper;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\Exception\ValidationFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RemoveProductController
 */
final class RemoveProductController extends AbstractController
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
     * RemoveProductController constructor.
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
     * @Route("/cart/{cartId}/product/{productId}", methods={"DELETE"}, name="remove_product_from_cart")
     *
     * @param int $cartId
     * @param int $productId
     *
     * @return JsonResponse
     */
    public function removeProduct(int $cartId, int $productId): JsonResponse
    {
        $command = new RemoveProductCommand($cartId, $productId);

        try {
            $this->commandBus->dispatch($command);
        } catch (ValidationFailedException $exception) {
            $validationHelper = new ValidationHelper($exception->getViolations());

            return new JsonResponse($validationHelper->getErrors(), Response::HTTP_BAD_REQUEST);
        } catch (HandlerFailedException $exception) { //todo czy to dobrze, ze nie lapie ProductNotFoundException tylko to?
            return new JsonResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
