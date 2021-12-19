<?php declare(strict_types=1);

namespace DeadCodeFinder\UpdServer\MessageBus;

interface MessageBusInterface
{
    public function sendToQueue(array $data): void;
}
