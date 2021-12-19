<?php declare(strict_types=1);

namespace DeadCodeFinder\AnalysisServer\MessageBus;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class RmqMessageBus implements MessageBusInterface
{
    public const QUEUE_NAME = 'called_code';

    private AMQPChannel $channel;
    private $connection;

    public function __construct()
    {
        $this->connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
        $this->channel = $this->connection->channel();
        $this->channel->queue_declare(self::QUEUE_NAME, false, false, false, false);
    }

    public function consume(callable $callback): void
    {
        $this->channel->basic_consume(self::QUEUE_NAME, '', false, true, false, false, $callback);

        while ($this->channel->is_open()) {
            $this->channel->wait();
        }

        $this->channel->close();
        $this->connection->close();
    }


}
