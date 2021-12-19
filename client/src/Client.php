<?php

namespace DeadCodeFinder\Client;


class Client
{
    /**
     * @var string
     */
    private $host;
    /**
     * @var int
     */
    private $port;
    /**
     * @var string
     */
    private $auth;
    /**
     * @var string
     */
    private $env;
    /**
     * @var string
     */
    private $app;
    /**
     * @var string
     */
    private $documentRoot;

    public function __construct($config = array()) {
        $defaultConfig = array(
            'host' => 'localhost',
            'port' => 1234,
            'auth' => 'a3d7d9a7-97b9-46b1-ab89-188bf831751c',
            'env' => 'test',
            'app' => 'app',
            'documentRoot' => null,
        );

        $config = array_merge($defaultConfig, $config);
        $this->host = $config['host'];
        $this->port = (int) $config['port'];
        $this->auth = $config['auth'];
        $this->env = $config['env'];
        $this->app = $config['app'];
        $this->documentRoot = $config['documentRoot'];
    }

    public function checkForDeadCode()
    {
        $backTrace = debug_backtrace();

        $data = array(
            'requestUri' => isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : null,
            'requestMethod' => isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : null,
            'function' => isset($backTrace[1]['function']) ? $backTrace[1]['function'] : '',
            'location' => isset($backTrace[0]['file'], $backTrace[0]['line']) ? $this->normaliseFile($backTrace[0]['file']) . ':' . $backTrace[0]['line'] : '',
            'serverName' => isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : null,
            'clientIp' => isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : null,
            'appName' => $this->app,
            'env' => $this->env,
            'auth' => $this->auth,
            'accessedAt' => date('Y-m-d H:i:s'),
        );

        $this->sendViaUdp($data);
    }

    private function normaliseFile($file)
    {
        if ($this->documentRoot === null) {
            return $file;
        }

        return str_replace($this->documentRoot, '', $file);
    }

    /**
     * @param array $data
     * @return void
     */
    private function sendViaUdp($data)
    {
        $socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
        socket_set_nonblock($socket);
        $message = json_encode($data);
        socket_sendto($socket, $message, strlen($message), 0, $this->host, $this->port);
        socket_close($socket);
    }
}
