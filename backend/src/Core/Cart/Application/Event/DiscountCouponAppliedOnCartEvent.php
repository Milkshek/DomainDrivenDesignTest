<?php

declare(strict_types=1);

namespace App\Core\Cart\Application\Event;

use DateTimeImmutable;
use Symfony\Component\Messenger\Attribute\AsMessage;
use Symfony\Component\Uid\Uuid;

#[AsMessage('async')]
final readonly class DiscountCouponAppliedOnCartEvent implements CartEventInterface
{
    public function __construct(
        private Uuid $cartId,
        private Uuid $discountCouponId,
        private DateTimeImmutable $appliedAt,
        private int $version,
    ) {}

    public function getId(): Uuid
    {
        return $this->cartId;
    }

    public function getDate(): DateTimeImmutable {
        return $this->appliedAt;
    }

    public function getAction(): string
    {
        return 'discount_coupon_applied_on_cart';
    }

    public function getData(): string
    {
        return json_encode([
            'cartId' => $this->cartId->toString(),
            'discountCouponId' => $this->discountCouponId->toString(),
            'appliedAt' => $this->appliedAt->format('Y-m-d H:i:s'),
        ]);
    }

    public function getVersion(): int
    {
        return $this->version;
    }
}
