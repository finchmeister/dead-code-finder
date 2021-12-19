<?php declare(strict_types=1);

namespace DeadCodeFinder\AnalysisServer\MessageBus;

interface MessageBusInterface
{
    public function consume(callable $callback): void;
}
