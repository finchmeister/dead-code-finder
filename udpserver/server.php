<?php


use DeadCodeFinder\UpdServer\Persistence\Mysql;
use DeadCodeFinder\UpdServer\UdpServer;

require_once __DIR__.'/vendor/autoload.php';

$server = new UdpServer(new Mysql());

$server->createServer();
