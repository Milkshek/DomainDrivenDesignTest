<?php

declare(strict_types=1);

namespace App\Core\Cart\Application\Command;

use App\Core\Cart\Infrastructure\CartRepositoryInterface;
use App\Core\Cart\Infrastructure\DiscountCouponRepositoryInterface;
use App\Core\Cart\Infrastructure\Projection\Cart\AddDiscountCouponToCartProjection;
use DateTimeImmutable;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler]
final readonly class AddDiscountCouponToCartCommandHandler
{
    public function __construct(
        private DiscountCouponRepositoryInterface $discountCouponRepository,
        private CartRepositoryInterface $cartRepository,
        private MessageBusInterface $messageBus,
    ) {}

    public function __invoke(AddDiscountCouponToCartCommand $command): void {
        $discountCoupon = $this->discountCouponRepository->getByCode($command->discountCouponCode);
        if($discountCoupon === null) {
            throw new \DomainException('Discount Coupon code not found');
        }

        $cart = $this->cartRepository->getById($command->cartId);
        if($cart === null) {
            throw new \DomainException('Cart not found');
        }

        if(!$discountCoupon->isRevoked()) {
            throw new \DomainException('Discount Coupon code is revoked');
        }

        if($discountCoupon->createdAt->add(new \DateInterval('P2M'))->getTimestamp() > (new DateTimeImmutable())->getTimestamp()) {
            throw new \DomainException('Discount Coupon code is expired');
        }

        if($discountCoupon->numberOfUses > 10) {
            throw new \DomainException('Discount Coupon code is expired');
        }

        $this->messageBus->dispatch(
            new AddDiscountCouponToCartProjection(
                $discountCoupon->id,
                $cart->id,
                new DateTimeImmutable(),
            )
        );
    }
}
