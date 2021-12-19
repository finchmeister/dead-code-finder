<?php

use DeadCodeFinder\Client\Client;

require_once __DIR__.'/../vendor/autoload.php';

$deadCodeClient = new Client(array('documentRoot' => '/Users/jfinch/PersonalProjects/dead-code-finder/client/public'));

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
