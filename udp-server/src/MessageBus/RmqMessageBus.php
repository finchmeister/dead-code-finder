<?php declare(strict_types=1);

namespace DeadCodeFinder\UpdServer\MessageBus;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RmqMessageBus implements MessageBusInterface
{
    public const QUEUE_NAME = 'called_code';

    private AMQPChannel $channel;

    public function __construct()
    {
        $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
        $this->channel = $connection->channel();
        $this->channel->queue_declare(self::QUEUE_NAME, false, false, false, false);
    }

    public function sendToQueue(array $data): void
    {
        $this->channel->basic_publish(
            new AMQPMessage(json_encode($data)),
            '',
            self::QUEUE_NAME
        );
    }
}
