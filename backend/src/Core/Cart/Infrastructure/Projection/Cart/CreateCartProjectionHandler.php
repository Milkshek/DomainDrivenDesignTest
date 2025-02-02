<?php

declare(strict_types=1);

namespace App\Core\Cart\Infrastructure\Projection\Cart;

use App\Core\Cart\Application\Event\CartCreatedEvent;
use App\Core\Cart\Infrastructure\CartRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler]
final readonly class CreateCartProjectionHandler
{
    public function __construct(
        private CartRepositoryInterface $cartRepository,
        private MessageBusInterface $messageBus,
    ) {
    }

    public function __invoke(CreateCartProjection $projection): void
    {
        $this->cartRepository->create($projection->id, $projection->createdAt);

        $this->messageBus->dispatch(new CartCreatedEvent($projection->id, $projection->createdAt));
    }
}
