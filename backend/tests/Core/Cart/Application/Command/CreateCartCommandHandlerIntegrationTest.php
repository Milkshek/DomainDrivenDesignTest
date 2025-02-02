<?php

declare(strict_types=1);

namespace App\Tests\Core\Cart\Application\Command;

use App\Core\Cart\Application\Command\CreateCartCommand;
use App\Core\Cart\Application\Command\CreateCartCommandHandler;
use App\Core\Cart\Infrastructure\Projection\Cart\CreateCartProjection;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\InMemory\InMemoryTransport;
use Symfony\Component\Uid\Uuid;

final  class CreateCartCommandHandlerIntegrationTest extends KernelTestCase
{

    private InMemoryTransport $messageTransport;
    private CreateCartCommandHandler $handler;

    public function setUp(): void {
        self::bootKernel();
        $this->messageTransport = static::getContainer()->get('messenger.transport.async');
        $this->handler = static::getContainer()->get(CreateCartCommandHandler::class);
    }

    /** @test */
    public function itShouldCreateCart(): void {
        ($this->handler)(new CreateCartCommand(
            Uuid::v4(),
        ));

        $this->assertCount(1, $this->messageTransport->getSent());
        /** @var Envelope $envelope */
        $envelope = current($this->messageTransport->getSent());
        self::assertInstanceOf(CreateCartProjection::class, $envelope->getMessage());
    }
}
