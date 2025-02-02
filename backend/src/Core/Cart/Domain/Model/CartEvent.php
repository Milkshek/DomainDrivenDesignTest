<?php

declare(strict_types=1);


namespace App\Core\Cart\Domain\Model;

use Symfony\Component\Uid\Uuid;

final readonly class CartEvent
{
    public function __construct(
        public Uuid $id,
        public string $action,
        public string $version,
        public string $data,
        public \DateTimeImmutable $createdAt,
        public \DateTimeImmutable $updatedAt,
    ) {}
}
