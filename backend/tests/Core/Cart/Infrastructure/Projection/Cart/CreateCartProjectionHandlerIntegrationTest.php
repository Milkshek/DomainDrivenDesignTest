<?php

declare(strict_types=1);

namespace App\Tests\Core\Cart\Infrastructure\Projection\Cart;

use App\Core\Cart\Application\Command\CreateCartCommand;
use App\Core\Cart\Application\Command\CreateCartCommandHandler;
use App\Core\Cart\Application\Event\CartCreatedEvent;
use App\Core\Cart\Infrastructure\CartRepositoryInterface;
use App\Core\Cart\Infrastructure\Projection\Cart\CreateCartProjection;
use App\Core\Cart\Infrastructure\Projection\Cart\CreateCartProjectionHandler;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\InMemory\InMemoryTransport;
use Symfony\Component\Uid\Uuid;

final  class CreateCartProjectionHandlerIntegrationTest extends KernelTestCase
{

    private InMemoryTransport $messageTransport;
    private CreateCartProjectionHandler $handler;
    private CartRepositoryInterface $cartRepository;

    public function setUp(): void {
        self::bootKernel();
        $this->messageTransport = static::getContainer()->get('messenger.transport.async');
        $this->cartRepository = $this->createMock(CartRepositoryInterface::class);
        self::getContainer()->set(CartRepositoryInterface::class, $this->cartRepository);
        $this->handler = static::getContainer()->get(CreateCartProjectionHandler::class);
    }

    /** @test */
    public function itShouldPersistCart(): void {
        $this->cartRepository->expects($this->once())->method('create');

        ($this->handler)(new CreateCartProjection(
            Uuid::v4(),
            new \DateTimeImmutable(),
        ));

        $this->assertCount(1, $this->messageTransport->getSent());
        /** @var Envelope $envelope */
        $envelope = current($this->messageTransport->getSent());
        self::assertInstanceOf(CartCreatedEvent::class, $envelope->getMessage());
    }
}
