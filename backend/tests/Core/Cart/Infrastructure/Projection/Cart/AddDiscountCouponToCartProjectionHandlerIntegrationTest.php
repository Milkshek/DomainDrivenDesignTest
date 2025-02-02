<?php

declare(strict_types=1);

namespace App\Tests\Core\Cart\Infrastructure\Projection\Cart;

use App\Core\Cart\Application\Command\CreateCartCommand;
use App\Core\Cart\Application\Command\CreateCartCommandHandler;
use App\Core\Cart\Application\Event\CartCreatedEvent;
use App\Core\Cart\Application\Event\DiscountCouponAppliedOnCartEvent;
use App\Core\Cart\Application\Event\DiscountCouponUsedEvent;
use App\Core\Cart\Infrastructure\CartRepositoryInterface;
use App\Core\Cart\Infrastructure\DiscountCouponRepositoryInterface;
use App\Core\Cart\Infrastructure\Projection\Cart\AddDiscountCouponToCartProjection;
use App\Core\Cart\Infrastructure\Projection\Cart\AddDiscountCouponToCartProjectionHandler;
use App\Core\Cart\Infrastructure\Projection\Cart\CreateCartProjection;
use App\Core\Cart\Infrastructure\Projection\Cart\CreateCartProjectionHandler;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\InMemory\InMemoryTransport;
use Symfony\Component\Uid\Uuid;

final  class AddDiscountCouponToCartProjectionHandlerIntegrationTest extends KernelTestCase
{

    private InMemoryTransport $messageTransport;
    private AddDiscountCouponToCartProjectionHandler $handler;
    private CartRepositoryInterface $cartRepository;
    private DiscountCouponRepositoryInterface $discountCouponRepository;

    public function setUp(): void {
        self::bootKernel();
        $this->messageTransport = static::getContainer()->get('messenger.transport.async');
        $this->cartRepository = $this->createMock(CartRepositoryInterface::class);
        self::getContainer()->set(CartRepositoryInterface::class, $this->cartRepository);
        $this->discountCouponRepository = $this->createMock(DiscountCouponRepositoryInterface::class);
        self::getContainer()->set(DiscountCouponRepositoryInterface::class, $this->discountCouponRepository);
        $this->handler = static::getContainer()->get(AddDiscountCouponToCartProjectionHandler::class);
    }

    /** @test */
    public function itShouldApplyDiscountCouponOnCart(): void {
        $this->cartRepository->expects($this->once())->method('save');
        $this->discountCouponRepository->expects($this->once())->method('save');

        ($this->handler)(new AddDiscountCouponToCartProjection(
            Uuid::v4(), // Get from fixtures
            Uuid::v4(), // Get from fixtures
            new \DateTimeImmutable(),
        ));

        $this->assertCount(2, $this->messageTransport->getSent());
        /** @var Envelope[] $envelopes */
        $envelopes = $this->messageTransport->getSent();
        self::assertInstanceOf(DiscountCouponAppliedOnCartEvent::class, $envelopes[0]->getMessage());
        self::assertInstanceOf(DiscountCouponUsedEvent::class, $envelopes[1]->getMessage());
    }
}
