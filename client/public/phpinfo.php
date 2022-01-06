<?php

use DeadCodeFinder\Client\Client;

require_once __DIR__.'/../vendor/autoload.php';

$deadCodeClient = new Client(array('documentRoot' => __DIR__));

$deadCodeClient->checkForDeadCode();

function hello() {
    global $deadCodeClient;
    $deadCodeClient->checkForDeadCode();
}

function notCalled() {
    global $deadCodeClient;
    $deadCodeClient->checkForDeadCode();
}

hello();

$deadCodeClient->checkForDeadCode();

phpinfo();
