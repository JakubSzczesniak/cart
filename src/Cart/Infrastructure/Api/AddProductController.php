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

use App\Cart\Application\Command\AddProductCommand;
use App\Cart\Domain\Event\ProductAddedEvent;
use App\Shared\Infrastructure\ValidationHelper;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\ValidationFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AddProductController
 */
final class AddProductController extends AbstractController
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
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * AddProductController constructor.
     *
     * @param MessageBusInterface      $commandBus
     * @param LoggerInterface          $logger
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(MessageBusInterface $commandBus, LoggerInterface $logger, EventDispatcherInterface $eventDispatcher)
    {
        $this->commandBus = $commandBus;
        $this->logger = $logger;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Add product to cart
     *
     * @Route("/cart/{cartId}/products", methods={"POST"}, name="add_product_to_cart")
     *
     * @param int     $cartId
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function addProduct(int $cartId, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $command = new AddProductCommand($cartId, $data['productId']);

        try {
            $this->commandBus->dispatch($command);

            $this->eventDispatcher->dispatch(new ProductAddedEvent($command->getCartId(), $command->getProductId()));
        } catch (ValidationFailedException $exception) {
            $validationHelper = new ValidationHelper($exception->getViolations());

            return new JsonResponse($validationHelper->getErrors(), Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
