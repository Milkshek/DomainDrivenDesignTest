<?php

declare(strict_types=1);

namespace App\Core\Cart\Infrastructure\Projection\Cart;

use App\Core\Cart\Application\Event\CartCreatedEvent;
use App\Core\Cart\Application\Event\DiscountCouponAppliedOnCartEvent;
use App\Core\Cart\Application\Event\DiscountCouponUsedEvent;
use App\Core\Cart\Domain\Model\Cart;
use App\Core\Cart\Domain\Model\DiscountCoupon\DiscountCoupon;
use App\Core\Cart\Domain\Model\DiscountCouponEvent;
use App\Core\Cart\Infrastructure\CartRepositoryInterface;
use App\Core\Cart\Infrastructure\DiscountCouponEventStoreRepositoryInterface;
use App\Core\Cart\Infrastructure\DiscountCouponRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Uid\Uuid;

#[AsMessageHandler]
final readonly class AddDiscountCouponToCartProjectionHandler
{
    public function __construct(
        private DiscountCouponRepositoryInterface $discountCouponRepository,
        private CartRepositoryInterface $cartRepository,
        private MessageBusInterface $messageBus,
    ) {
    }

    public function __invoke(AddDiscountCouponToCartProjection $projection): void
    {
        $discountCouponDTO = $this->getLastVersionOfDiscountCoupon($projection->discountCouponId);
        if($discountCouponDTO->discountCoupon === null) {
            throw new \DomainException('Discount Coupon code not found');
        }

        $cartDTO = $this->getLastVersionOfCart($projection->cartId);
        if($cartDTO->cart === null) {
            throw new \DomainException('Cart not found');
        }

        $cartDTO->cart->addCoupon($discountCouponDTO->discountCoupon);
        $this->cartRepository->save($cartDTO->cart);

        $discountCouponDTO->discountCoupon->use();
        $this->discountCouponRepository->save($discountCouponDTO->discountCoupon);

        $this->messageBus->dispatch(new DiscountCouponAppliedOnCartEvent(
            $projection->cartId,
            $projection->discountCouponId,
            $projection->appliedAt,
            $cartDTO->version + 1,
        ));

        $this->messageBus->dispatch(new DiscountCouponUsedEvent(
            $projection->discountCouponId,
            $projection->appliedAt,
            $discountCouponDTO->version + 1,
        ));
    }

    private function getLastVersionOfCart(Uuid $id): CartDTO {
        $cart = $this->cartRepository->getById($id);

        // TODO build from all version from event store

        return new CartDTO(
            $cart,
            1,
        );
    }

    private function getLastVersionOfDiscountCoupon(Uuid $id): DiscountCouponDTO {
        $discountCoupon = $this->discountCouponRepository->getById($id);

        // TODO build from all version from event store

        return new DiscountCouponDTO(
            $discountCoupon,
            1,
        );
    }
}
