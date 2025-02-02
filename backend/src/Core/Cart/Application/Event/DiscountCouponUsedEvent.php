<?php

declare(strict_types=1);

namespace App\Core\Cart\Application\Event;

use DateTimeImmutable;
use Symfony\Component\Messenger\Attribute\AsMessage;
use Symfony\Component\Uid\Uuid;

#[AsMessage('async')]
final readonly class DiscountCouponUsedEvent implements DiscountCouponEventInterface
{
    public function __construct(
        private Uuid $id,
        private DateTimeImmutable $appliedAt,
        private int $version,
    ) {}

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getDate(): DateTimeImmutable {
        return $this->appliedAt;
    }

    public function getAction(): string
    {
        return 'discount_coupon_used';
    }

    public function getData(): string
    {
        return json_encode([
            'id' => $this->id->toString(),
            'appliedAt' => $this->appliedAt->format('Y-m-d H:i:s'),
        ]);
    }

    public function getVersion(): int
    {
        return $this->version;
    }
}
