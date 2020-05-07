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

use App\Cart\Application\Query\GetContentsQuery;
use App\Shared\Domain\Paginator;
use App\Shared\Infrastructure\ValidationHelper;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\ValidationFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class GetCartContentsController
 */
final class GetCartContentsController extends AbstractController
{
    /**
     * @var MessageBusInterface
     */
    private $queryBus;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * GetCartContentsController constructor.
     *
     * @param MessageBusInterface $queryBus
     * @param LoggerInterface     $logger
     */
    public function __construct(MessageBusInterface $queryBus, LoggerInterface $logger)
    {
        $this->queryBus = $queryBus;
        $this->logger = $logger;
    }

    /**
     * Get cart contents
     *
     * @Route("/cart/{cartId}", methods={"GET"}, name="get_cart_contents")
     *
     * @param int     $cartId
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getCartContents(int $cartId, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $page = $data['page'] ?? 1;
        $paginator = new Paginator($page);

        $command = new GetContentsQuery($cartId, $paginator->getLimit(), $paginator->getOffset());

        try {
            $envelope = $this->queryBus->dispatch($command);

            /** @var HandledStamp $handled */
            $handled = $envelope->last(HandledStamp::class);
            $cartContents = $handled->getResult();
        } catch (ValidationFailedException $exception) {
            $validationHelper = new ValidationHelper($exception->getViolations());

            return new JsonResponse($validationHelper->getErrors(), Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse($cartContents, Response::HTTP_OK);
    }
}
