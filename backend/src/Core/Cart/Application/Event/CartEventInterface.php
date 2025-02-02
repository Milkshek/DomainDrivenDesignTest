<?php

namespace App\Core\Cart\Application\Event;

use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

interface CartEventInterface
{
    public function getId(): Uuid;

    public function getAction(): string;

    public function getData(): string;

    public function getVersion(): int;

    public function getDate(): DateTimeImmutable;
}
