<?php

declare(strict_types=1);


namespace App\Core\Cart\Infrastructure\Doctrine;

use App\Core\Cart\Domain\Model\Cart;
use App\Core\Cart\Infrastructure\CartRepositoryInterface;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

final readonly class CartRepository implements CartRepositoryInterface
{
    public function create(Uuid $id, DateTimeImmutable $createdAt): void
    {
        throw new \Exception('Not implemented');
    }

    public function getById(Uuid $id): Cart
    {
        throw new \Exception('Not implemented');
    }

    public function save(Cart $cart): void
    {
        throw new \Exception('Not implemented');
    }
}
