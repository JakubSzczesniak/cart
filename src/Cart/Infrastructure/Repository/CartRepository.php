<?php

declare(strict_types=1);

/*
 * This file is part of the Symfony 4 CQRS Cart Project.
 *
 * (c) Jakub Szcześniak
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Cart\Infrastructure\Repository;

use App\Cart\Domain\Entity\Cart;
use App\Cart\Domain\Repository\CartRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class CartRepository
 */
final class CartRepository extends ServiceEntityRepository implements CartRepositoryInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * CartRepository constructor.
     *
     * @param ManagerRegistry        $registry
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Cart::class);
        $this->entityManager = $entityManager;
    }

    /**
     * @param Cart $cart
     *
     * @return bool
     */
    public function exists(Cart $cart): bool
    {
        return true; //todo
    }

    /**
     * @param Cart $cart
     */
    public function add(Cart $cart): void
    {
        $this->entityManager->persist($cart);
    }

    /**
     * @param Cart $cart
     */
    public function remove(Cart $cart): void
    {
        $this->entityManager->remove($cart);
    }
}
