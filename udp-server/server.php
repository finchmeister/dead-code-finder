<?php


use DeadCodeFinder\UpdServer\MessageBus\RmqMessageBus;
use DeadCodeFinder\UpdServer\UdpServer;

require_once __DIR__.'/vendor/autoload.php';

$server = new UdpServer(new RmqMessageBus());

$server->createServer();
