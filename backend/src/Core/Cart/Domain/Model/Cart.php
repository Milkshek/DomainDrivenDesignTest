<?php

declare(strict_types=1);

namespace App\Core\Cart\Domain\Model;

use App\Core\Cart\Domain\Model\DiscountCoupon\DiscountCoupon;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

final class Cart
{
    /**
     * @param CartItem[] $items
     * @param DiscountCoupon[] $discountCoupons
     */
    public function __construct(
        public readonly Uuid $id,
        public readonly DateTimeImmutable $createdAt,
        public DateTimeImmutable $updatedAt,
        public int $totalAmountInCents = 0,
        public array $items = [],
        public array $discountCoupons = [],
    ) {}

    public function addCoupon(DiscountCoupon $coupon): void {
        $this->discountCoupons[] = $coupon;

        $this->calculateTotalAmountInCents();
    }

    private function calculateTotalAmountInCents(): void {
        $this->totalAmountInCents = $this->applyAllDiscountCoupons($this->getItemsTotalAmountInCents());
    }

    private function getItemsTotalAmountInCents(): int {
        $total = 0;
        array_reduce(
            $this->items,
            fn (int $sum, CartItem $cartItem) => $sum + $cartItem->totalAmountInCents,
            $total,
        );

        return $total;
    }

    private function applyAllDiscountCoupons(int $totalItemAmountInCents): int
    {
        array_reduce(
            $this->discountCoupons,
            fn (int $discounted, DiscountCoupon $discountCoupon) => $discountCoupon->apply($discounted),
            $totalItemAmountInCents,
        );

        return $totalItemAmountInCents;
    }
}
