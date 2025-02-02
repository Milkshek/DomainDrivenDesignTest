<?php

declare(strict_types=1);

namespace App\Core\Cart\Application\Event;

use DateTimeImmutable;
use Symfony\Component\Messenger\Attribute\AsMessage;
use Symfony\Component\Uid\Uuid;

#[AsMessage('async')]
final readonly class CartCreatedEvent implements CartEventInterface
{
    public function __construct(
        public Uuid $id,
        public DateTimeImmutable $createdAt,
    ) {}

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getDate(): DateTimeImmutable {
        return $this->createdAt;
    }

    public function getAction(): string
    {
        return 'cart_created';
    }

    public function getData(): string
    {
        return json_encode([
            'id' => $this->id->toString(),
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
        ]);
    }

    public function getVersion(): int
    {
        return 0;
    }
}
