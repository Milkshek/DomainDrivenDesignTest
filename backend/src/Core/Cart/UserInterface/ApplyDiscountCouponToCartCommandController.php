<?php

declare(strict_types=1);


namespace App\Core\Cart\UserInterface;

use App\Core\Cart\Application\Command\AddDiscountCouponToCartCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\MessageBusInterface;

final class ApplyDiscountCouponToCartCommandController extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface $messageBus,
    )
    {
    }

    public function create(
        #[MapRequestPayload] AddDiscountCouponToCartCommand $command,
    ): JsonResponse {
        $this->messageBus->dispatch($command);

        return $this->json([]);
    }
}
