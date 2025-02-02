<?php

declare(strict_types=1);


namespace App\Core\Cart\Infrastructure;

use App\Core\Cart\Domain\Model\CartEvent;
use Symfony\Component\Uid\Uuid;

interface CartEventStoreRepositoryInterface
{
    public function insert(Uuid $id, string $action, string $data, int $version, \DateTimeImmutable $createdAt): void;
}
