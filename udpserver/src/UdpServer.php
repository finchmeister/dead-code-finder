<?php declare(strict_types=1);

namespace DeadCodeFinder\UpdServer;

use DeadCodeFinder\UpdServer\Persistence\Persistence;
use React\Datagram\Factory;
use React\Datagram\Socket;

class UdpServer {

    public const ADDRESS = 'localhost:1234';

    private Factory $factory;

    private Persistence $persistence;

    public function __construct(Persistence $persistence)
    {
        $this->factory = new Factory();
        $this->persistence = $persistence;
    }

    public function createServer(): void
    {
        $this->factory->createServer(self::ADDRESS)->then(function (Socket $server) {
            $server->on('message', function($message, $address, $server) {
                $data = json_decode($message, true);
                $data['serverIp'] = explode(':', $address)[0];
                $this->persistence->persist($this->createCalledCodeDto($data));
                echo 'client ' . $address . ': ' . $message . PHP_EOL;
            });
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
