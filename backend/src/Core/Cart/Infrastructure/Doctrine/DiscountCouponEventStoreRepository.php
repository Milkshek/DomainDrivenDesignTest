<?php

declare(strict_types=1);


namespace App\Core\Cart\Infrastructure\Doctrine;

use App\Core\Cart\Infrastructure\CartEventStoreRepositoryInterface;
use App\Core\Cart\Infrastructure\DiscountCouponEventStoreRepositoryInterface;
use Symfony\Component\Uid\Uuid;

final readonly class DiscountCouponEventStoreRepository implements DiscountCouponEventStoreRepositoryInterface
{
    public function insert(Uuid $id,string $action,string $data,int $version,\DateTimeImmutable $createdAt) : void {
        throw new \Exception('Not implemented');
    }
}
