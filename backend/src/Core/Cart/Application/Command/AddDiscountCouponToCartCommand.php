<?php

declare(strict_types=1);


namespace App\Core\Cart\Application\Command;

use Symfony\Component\Messenger\Attribute\AsMessage;
use Symfony\Component\Uid\Uuid;

#[AsMessage]
final readonly class AddDiscountCouponToCartCommand
{
    public function __construct(
        public string $discountCouponCode,
        public Uuid $cartId,
    ) {}
}
