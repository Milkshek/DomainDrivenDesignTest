<?php

declare(strict_types=1);

namespace App\Core\Cart\Domain\Model;

use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

final class CartItem
{
    public function __construct(
        public readonly Uuid $id,
        public readonly DateTimeImmutable $createdAt,
        public DateTimeImmutable $updatedAt,
        public int $number,
        public int $amountInCentsPerUnit,
        public int $totalAmountInCents = 0,
    ) {}

    public function addUnit(int $number): void {
        $this->number += $number;
        $this->calculateTotalAmountInCents();
    }

    private function calculateTotalAmountInCents(): void {
        $this->totalAmountInCents = $this->number * $this->amountInCentsPerUnit;
    }
}
