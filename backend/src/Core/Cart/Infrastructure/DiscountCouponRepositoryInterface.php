<?php

declare(strict_types=1);


namespace App\Core\Cart\Infrastructure;

use App\Core\Cart\Domain\Model\DiscountCoupon\DiscountCoupon;
use Symfony\Component\Uid\Uuid;

interface DiscountCouponRepositoryInterface
{
    public function getByCode(string $code): ?DiscountCoupon;

    public function getById(Uuid $id): ?DiscountCoupon;

    public function save(DiscountCoupon $discountCoupon): void;
}
