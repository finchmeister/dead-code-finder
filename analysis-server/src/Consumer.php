<?php declare(strict_types=1);

namespace DeadCodeFinder\AnalysisServer;

use DeadCodeFinder\AnalysisServer\MessageBus\MessageBusInterface;
use DeadCodeFinder\AnalysisServer\Persistence\PersistenceInterface;
use PhpAmqpLib\Message\AMQPMessage;

class Consumer
{
    private MessageBusInterface $messageBus;
    private PersistenceInterface $persistence;

    public function __construct(
        MessageBusInterface $messageBus,
        PersistenceInterface $persistence
    )
    {
        $this->messageBus = $messageBus;
        $this->persistence = $persistence;
    }

    public function run(): void
    {
        $this->messageBus->consume(function (AMQPMessage $msg) {
            $calledCodeDto = $this->createCalledCodeDto(json_decode($msg->getBody(), true));
            $this->persistence->persist($calledCodeDto);
            echo ' [x] Persisted ', $msg->body, "\n";
        });
    }

    private function createCalledCodeDto(array $data): CalledCodeDto {
        return new CalledCodeDto(
            requestUri: $data['requestUri'],
            requestMethod: $data['requestMethod'],
            function: $data['function'],
            location: $data['location'],
            serverName: $data['serverName'],
            serverIp: $data['serverIp'],
            appName: $data['appName'],
            env: $data['env'],
            clientIp: $data['clientIp'],
            accessedAt: $data['accessedAt'],
        );
    }
}
