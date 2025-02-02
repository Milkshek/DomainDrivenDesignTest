<?php

declare(strict_types=1);


namespace App\Core\Cart\Infrastructure;

use App\Core\Cart\Domain\Model\Cart;
use Symfony\Component\Uid\Uuid;

interface CartRepositoryInterface
{
    public function create(Uuid $id, \DateTimeImmutable $createdAt): void;

    public function getById(Uuid $id): Cart;

    public function save(Cart $cart): void;
}
