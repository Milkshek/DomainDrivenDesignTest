<?php

declare(strict_types=1);

namespace App\Core\Cart\Application\Command;

use App\Core\Cart\Infrastructure\Projection\Cart\CreateCartProjection;
use DateTimeImmutable;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler]
final readonly class CreateCartCommandHandler
{
    public function __construct(
        private MessageBusInterface $messageBus,
    ) {}

    public function __invoke(CreateCartCommand $command): void {
        $this->messageBus->dispatch(
            new CreateCartProjection(
                $command->id,
                new DateTimeImmutable(),
            )
        );
    }
}
