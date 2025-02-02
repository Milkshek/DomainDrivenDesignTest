<?php

declare(strict_types=1);


namespace App\Core\Cart\UserInterface;

use App\Core\Cart\Application\Command\CreateCartCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Uid\Uuid;

final class CreateCommandController extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface $messageBus,
    )
    {
    }

    public function create(): JsonResponse {
        $id = Uuid::v4();
        $this->messageBus->dispatch(new CreateCartCommand($id));

        return $this->json(['id' => $id]);
    }
}
