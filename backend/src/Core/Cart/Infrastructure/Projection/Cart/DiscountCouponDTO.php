<?php

declare(strict_types=1);


namespace App\Core\Cart\Infrastructure\Projection\Cart;

use App\Core\Cart\Domain\Model\DiscountCoupon\DiscountCoupon;

final readonly class DiscountCouponDTO
{

    public function __construct(
        public DiscountCoupon $discountCoupon,
        public int $version,
    )
    {
    }
}
