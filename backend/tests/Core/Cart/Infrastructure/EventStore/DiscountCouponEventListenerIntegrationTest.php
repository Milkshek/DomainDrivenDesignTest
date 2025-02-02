<?php

declare(strict_types=1);

namespace App\Tests\Core\Cart\Infrastructure\EventStore;

use App\Core\Cart\Application\Command\CreateCartCommand;
use App\Core\Cart\Application\Command\CreateCartCommandHandler;
use App\Core\Cart\Application\Event\CartCreatedEvent;
use App\Core\Cart\Application\Event\DiscountCouponEventInterface;
use App\Core\Cart\Application\Event\DiscountCouponUsedEvent;
use App\Core\Cart\Infrastructure\CartEventStoreRepositoryInterface;
use App\Core\Cart\Infrastructure\CartRepositoryInterface;
use App\Core\Cart\Infrastructure\DiscountCouponEventStoreRepositoryInterface;
use App\Core\Cart\Infrastructure\EventStore\CartEventListener;
use App\Core\Cart\Infrastructure\EventStore\DiscountCouponEventListener;
use App\Core\Cart\Infrastructure\Projection\Cart\CreateCartProjection;
use App\Core\Cart\Infrastructure\Projection\Cart\CreateCartProjectionHandler;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\InMemory\InMemoryTransport;
use Symfony\Component\Uid\Uuid;

final  class DiscountCouponEventListenerIntegrationTest extends KernelTestCase
{
    private DiscountCouponEventStoreRepositoryInterface $discountCouponEventStoreRepository;
    private DiscountCouponEventListener $listener;

    public function setUp(): void {
        self::bootKernel();
        $this->discountCouponEventStoreRepository = $this->createMock(DiscountCouponEventStoreRepositoryInterface::class);
        self::getContainer()->set(DiscountCouponEventStoreRepositoryInterface::class, $this->discountCouponEventStoreRepository);
        $this->listener = static::getContainer()->get(DiscountCouponEventListener::class);
    }

    /** @test */
    public function itShouldPersistCartEvent(): void {
        $event = new DiscountCouponUsedEvent(
            Uuid::v4(),
            new \DateTimeImmutable(),
            1,
        );

        $this->discountCouponEventStoreRepository->expects($this->once())->method('insert')->with(
            $event->getId(),
            $event->getAction(),
            $event->getData(),
            $event->getVersion(),
            $event->getDate(),
        );

        ($this->listener)($event);
    }
}
