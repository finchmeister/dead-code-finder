<?php

const HOST = 'localhost';
const PORT = '1234';

/**
 * @param array $message
 * @return void
 */
function send($data): void
{
    $socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
    socket_set_nonblock($socket);
    $backTrace = debug_backtrace();
    $data['function'] = isset($backTrace[1]['function']) ? $backTrace[1]['function'] : '';

    $message = json_encode($data);

    $res = socket_sendto($socket, $message, strlen($message), 0, HOST, PORT);
    socket_close($socket);

//    echo ($res ? 'Sent' : 'Lost') . PHP_EOL;
}

$message = array(
    'requestUri' => $_SERVER['REQUEST_URI'] ?? null,
    'requestMethod' => $_SERVER['REQUEST_METHOD'] ?? null,
    'function' => '',
    'location' => __FILE__ . ':' . __LINE__, // TODO needs to be location of parent function
    'serverName' => $_SERVER['SERVER_NAME'] ?? null,
    'clientIp' => $_SERVER['REMOTE_ADDR'] ?? null,
    'appName' => 'Bob',
    'env' => 'live',
    'auth' => 'a3d7d9a7-97b9-46b1-ab89-188bf831751c',
    'accessedAt' => date('Y-m-d H:i:s'),
);

function test_function($message) {
    send($message);
}
$start = microtime(true);
for ($i = 0; $i < 10000; $i++) {
    send($message);
}
//test_function($message);
echo 'Time taken: ' . (microtime(true) - $start) . PHP_EOL;