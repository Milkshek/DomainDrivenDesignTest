<?php

declare(strict_types=1);

namespace App\Core\Cart\Infrastructure\Projection\Cart;

use DateTimeImmutable;
use Symfony\Component\Messenger\Attribute\AsMessage;
use Symfony\Component\Uid\Uuid;

#[AsMessage('async')]
final readonly class CreateCartProjection
{
    public function __construct(
        public Uuid $id,
        public DateTimeImmutable $createdAt,
    ) {}
}
