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

use App\Cart\Application\Command\CreateCartCommand;
use App\Shared\Infrastructure\ValidationHelper;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\ValidationFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CreateCartController
 */
final class CreateCartController extends AbstractController
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
     * CreateCartController constructor.
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
     * Create new cart
     *
     * @Route("/cart", methods={"POST"}, name="create_cart")
     *
     * @return JsonResponse
     */
    public function createCart(): JsonResponse
    {
        $command = new CreateCartCommand();

        try {
            $envelope = $this->commandBus->dispatch($command);

            /** @var HandledStamp $handled */
            $handled = $envelope->last(HandledStamp::class);
            $id = $handled->getResult();
        } catch (ValidationFailedException $exception) {
            $validationHelper = new ValidationHelper($exception->getViolations());

            return new JsonResponse($validationHelper->getErrors(), Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse(['id' => $id], Response::HTTP_CREATED);
    }
}
