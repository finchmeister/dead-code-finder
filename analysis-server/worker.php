<?php

use DeadCodeFinder\AnalysisServer\Consumer;
use DeadCodeFinder\AnalysisServer\MessageBus\RmqMessageBus;
use DeadCodeFinder\AnalysisServer\Persistence\Mysql;

require_once __DIR__.'/vendor/autoload.php';

echo " [*] Waiting for messages. To exit press CTRL+C\n";

$consumer = new Consumer(
    new RmqMessageBus(),
    new Mysql()
);

$consumer->run();
