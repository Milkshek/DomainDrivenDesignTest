<?php

declare(strict_types=1);

namespace App\Core\Cart\Infrastructure\EventStore;

use App\Core\Cart\Application\Event\CartCreatedEvent;
use App\Core\Cart\Application\Event\CartEventInterface;
use App\Core\Cart\Infrastructure\CartEventStoreRepositoryInterface;
use App\Core\Cart\Infrastructure\CartRepositoryInterface;
use App\Core\Cart\Infrastructure\Projection\Cart\CreateCartProjection;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler]
final readonly class CartEventListener
{
    public function __construct(
        private CartEventStoreRepositoryInterface $cartEventStoreRepository,
    ) {
    }

    public function __invoke(CartEventInterface $event): void
    {
        $this->cartEventStoreRepository->insert(
            $event->getId(),
            $event->getAction(),
            $event->getData(),
            $event->getVersion(),
            $event->getDate(),
        );
    }
}
