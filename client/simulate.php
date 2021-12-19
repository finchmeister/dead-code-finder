<?php

use DeadCodeFinder\Client\Client;

require_once __DIR__.'/vendor/autoload.php';

$deadCodeClient = new Client();

function test_function() {
    global $deadCodeClient;
    $deadCodeClient->checkForDeadCode();
}

$start = microtime(true);
$n = isset($argv[1]) ? (int) $argv[1] : 10;

for ($i = 0; $i < $n; $i++) {
    test_function();
}
//test_function($message);
echo sprintf("Time Taken to send %s events: %.2f (s) \n", $n, (microtime(true) - $start));
