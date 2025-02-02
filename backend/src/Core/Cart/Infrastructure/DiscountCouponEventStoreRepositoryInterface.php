<?php

declare(strict_types=1);


namespace App\Core\Cart\Infrastructure;

use Symfony\Component\Uid\Uuid;

interface DiscountCouponEventStoreRepositoryInterface
{
    public function insert(Uuid $id,string $action,string $data,int $version,\DateTimeImmutable $createdAt);
}
