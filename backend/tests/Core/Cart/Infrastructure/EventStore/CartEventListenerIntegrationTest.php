<?php

declare(strict_types=1);

namespace App\Tests\Core\Cart\Infrastructure\EventStore;

use App\Core\Cart\Application\Command\CreateCartCommand;
use App\Core\Cart\Application\Command\CreateCartCommandHandler;
use App\Core\Cart\Application\Event\CartCreatedEvent;
use App\Core\Cart\Infrastructure\CartEventStoreRepositoryInterface;
use App\Core\Cart\Infrastructure\CartRepositoryInterface;
use App\Core\Cart\Infrastructure\EventStore\CartEventListener;
use App\Core\Cart\Infrastructure\Projection\Cart\CreateCartProjection;
use App\Core\Cart\Infrastructure\Projection\Cart\CreateCartProjectionHandler;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\InMemory\InMemoryTransport;
use Symfony\Component\Uid\Uuid;

final  class CartEventListenerIntegrationTest extends KernelTestCase
{
    private CartEventStoreRepositoryInterface $cartEventStoreRepository;
    private CartEventListener $listener;

    public function setUp(): void {
        self::bootKernel();
        $this->cartEventStoreRepository = $this->createMock(CartEventStoreRepositoryInterface::class);
        self::getContainer()->set(CartEventStoreRepositoryInterface::class, $this->cartEventStoreRepository);
        $this->listener = static::getContainer()->get(CartEventListener::class);
    }

    /** @test */
    public function itShouldPersistCartEvent(): void {
        $event = new CartCreatedEvent(
            Uuid::v4(),
            new \DateTimeImmutable(),
        );

        $this->cartEventStoreRepository->expects($this->once())->method('insert')->with(
            $event->getId(),
            $event->getAction(),
            $event->getData(),
            $event->getVersion(),
            $event->getDate(),
        );

        ($this->listener)($event);
    }
}
