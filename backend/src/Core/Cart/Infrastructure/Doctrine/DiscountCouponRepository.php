<?php

declare(strict_types=1);


namespace App\Core\Cart\Infrastructure\Doctrine;

use App\Core\Cart\Domain\Model\DiscountCoupon\DiscountCoupon;
use App\Core\Cart\Infrastructure\DiscountCouponRepositoryInterface;
use Symfony\Component\Uid\Uuid;

final readonly class DiscountCouponRepository implements DiscountCouponRepositoryInterface
{
    public function getByCode(string $code): ?DiscountCoupon
    {
        throw new \Exception('Not implemented');
    }

    public function getById(Uuid $id): ?DiscountCoupon
    {
        throw new \Exception('Not implemented');
    }

    public function save(DiscountCoupon $discountCoupon): void
    {
        throw new \Exception('Not implemented');
    }
}
