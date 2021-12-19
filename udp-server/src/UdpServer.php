<?php declare(strict_types=1);

namespace DeadCodeFinder\UpdServer;

use DeadCodeFinder\UpdServer\MessageBus\MessageBusInterface;
use React\Datagram\Factory;
use React\Datagram\Socket;

class UdpServer {

    public const ADDRESS = 'localhost:1234';

    private Factory $factory;

    private MessageBusInterface $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->factory = new Factory();
        $this->messageBus = $messageBus;
    }

    public function createServer(): void
    {
        $this->factory->createServer(self::ADDRESS)->then(function (Socket $server) {
            $server->on('message', function($message, $address, $server) {
                $data = json_decode($message, true);
                $data['serverIp'] = explode(':', $address)[0];
                $this->messageBus->sendToQueue($data);
                echo 'client ' . $address . ': ' . $message . PHP_EOL;
            });
        });
    }
}
