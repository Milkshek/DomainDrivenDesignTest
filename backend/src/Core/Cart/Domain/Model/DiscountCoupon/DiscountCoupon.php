<?php

declare(strict_types=1);

namespace App\Core\Cart\Domain\Model\DiscountCoupon;

use App\Core\Cart\Domain\Enum\DiscountCouponTypeEnum;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

abstract class DiscountCoupon
{
    public function __construct(
        public readonly Uuid $id,
        public string $name,
        public string $code,
        public readonly DateTimeImmutable $createdAt,
        public DateTimeImmutable $updatedAt,
        public int $numberOfUses,
        public ?DateTimeImmutable $revokeAt,
        public DiscountCouponTypeEnum $type,
    ) {}

    abstract function apply(int $amountInCents): int;

    public function revoke(): void {
        $this->revokeAt = new DateTimeImmutable();
    }

    public function isRevoked(): bool {
        return $this->revokeAt !== null;
    }

    public function use(): void {
        $this->numberOfUses = $this->numberOfUses + 1;
    }
}
