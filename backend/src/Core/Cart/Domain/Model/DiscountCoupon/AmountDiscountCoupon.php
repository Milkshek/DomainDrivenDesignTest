<?php

declare(strict_types=1);

namespace App\Core\Cart\Domain\Model\DiscountCoupon;

use App\Core\Cart\Domain\Enum\DiscountCouponTypeEnum;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

final class AmountDiscountCoupon extends DiscountCoupon
{
    public function __construct(
        Uuid $id,
        string $name,
        string $code,
        public int $discountAmountInCents,
        DateTimeImmutable $createdAt,
        DateTimeImmutable $updatedAt,
        int $numberOfUses,
        ?DateTimeImmutable $revokeAt,
    ) {
        parent::__construct($id, $name, $code, $createdAt, $updatedAt, $numberOfUses, $revokeAt, DiscountCouponTypeEnum::AMOUNT);
    }

    function apply(int $amountInCents): int
    {
        return $amountInCents - $this->discountAmountInCents;
    }
}
