<?php

declare(strict_types=1);


namespace App\Core\Cart\Infrastructure\Doctrine;

use App\Core\Cart\Infrastructure\CartEventStoreRepositoryInterface;
use Symfony\Component\Uid\Uuid;

final readonly class CartEventStoreRepository implements CartEventStoreRepositoryInterface
{
    public function insert(Uuid $id,string $action,string $data,int $version,\DateTimeImmutable $createdAt) : void {
        throw new \Exception('Not implemented');
    }

    public function getEventsById(Uuid $id): array
    {
        throw new \Exception('Not implemented');
    }
}
