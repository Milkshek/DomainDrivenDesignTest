<?php

declare(strict_types=1);

namespace App\Tests\Core\Cart\Application\Command;

use App\Core\Cart\Application\Command\AddDiscountCouponToCartCommand;
use App\Core\Cart\Application\Command\AddDiscountCouponToCartCommandHandler;
use App\Core\Cart\Infrastructure\Projection\Cart\AddDiscountCouponToCartProjection;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\InMemory\InMemoryTransport;
use Symfony\Component\Uid\Uuid;

final  class AddDiscountCouponToCartHandlerIntegrationTest extends KernelTestCase
{

    private InMemoryTransport $messageTransport;
    private AddDiscountCouponToCartCommandHandler $handler;

    public function setUp(): void {
        self::bootKernel();
        $this->messageTransport = static::getContainer()->get('messenger.transport.async');
        $this->handler = static::getContainer()->get(AddDiscountCouponToCartCommandHandler::class);
    }

    /** @test */
    public function itShouldNotApplyDiscountCouponOnCartWithNotFoundDiscountCoupon(): void {
        self::expectExceptionMessage('Discount Coupon code not found');

        ($this->handler)(new AddDiscountCouponToCartCommand(
            'test',
            Uuid::v4(), // Get from fixtures
        ));
    }

    /** @test */
    public function itShouldNotApplyDiscountCouponOnCartWithNotFoundCart(): void {
        self::expectExceptionMessage('Cart not found');

        ($this->handler)(new AddDiscountCouponToCartCommand(
            'VALID',// Get from fixtures
            Uuid::v4(),
        ));
    }

    /** @test */
    public function itShouldNotApplyDiscountCouponOnCartWithRevokedDiscountCoupon(): void {
        self::expectExceptionMessage('Discount Coupon code is revoked');

        ($this->handler)(new AddDiscountCouponToCartCommand(
            'REVOKED',// Get from fixtures
            Uuid::v4(),// Get from fixtures
        ));
    }

    /** @test */
    public function itShouldNotApplyDiscountCouponOnCartWithExpiredDiscountCoupon(): void {
        self::expectExceptionMessage('Discount Coupon code is expired');

        ($this->handler)(new AddDiscountCouponToCartCommand(
            'EXPIRED',// Get from fixtures
            Uuid::v4(),// Get from fixtures
        ));
    }

    /** @test */
    public function itShouldNotApplyDiscountCouponOnCartWithTooManyUsesDiscountCoupon(): void {
        self::expectExceptionMessage('Discount Coupon code is expired');

        ($this->handler)(new AddDiscountCouponToCartCommand(
            'USED',// Get from fixtures
            Uuid::v4(),// Get from fixtures
        ));
    }

    /** @test */
    public function itShouldApplyDiscountCouponOnCart(): void {
        ($this->handler)(new AddDiscountCouponToCartCommand(
            'test', // Get from fixtures
            Uuid::v4(), // Get from fixtures
        ));

        $this->assertCount(1, $this->messageTransport->getSent());
        /** @var Envelope $envelope */
        $envelope = current($this->messageTransport->getSent());
        self::assertInstanceOf(AddDiscountCouponToCartProjection::class, $envelope->getMessage());
    }
}
