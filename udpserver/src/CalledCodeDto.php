<?php declare(strict_types=1);

namespace DeadCodeFinder\UpdServer;

class CalledCodeDto
{
    public function __construct(
        public ?string $requestUri,
        public ?string $requestMethod,
        public string $function,
        public string $location,
        public ?string $serverName,
        public ?string $serverIp,
        public string $appName,
        public string $env,
        public ?string $clientIp,
        public string $accessedAt
    )
    {
    }
}
