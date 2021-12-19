<?php declare(strict_types=1);


namespace DeadCodeFinder\UpdServer\Persistence;

use DeadCodeFinder\UpdServer\CalledCodeDto;
use PDO;

class Mysql implements Persistence
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = new PDO(
            'mysql:dbname=deadcode;host=127.0.0.1;port=3306;charset=utf8',
            'root',
            'my-secret-pw'
        );
    }

    public function persist(CalledCodeDto $calledCodeDto): void
    {
        $stmt = $this->pdo->prepare('INSERT INTO called_code(
                        request_uri,
                        request_method,
                        function, 
                        location, 
                        server_name,
                        server_ip,
                        app_name, 
                        env, 
                        client_ip, 
                        accessed_at
                        ) VALUES (
                        :request_uri,
                        :request_method,
                        :function, 
                        :location, 
                        :server_name,
                        :server_ip,
                        :app_name, 
                        :env, 
                        :client_ip, 
                        :accessed_at

                                  )');
        $stmt->execute([
            ':request_uri' => $calledCodeDto->requestUri,
            ':request_method' => $calledCodeDto->requestMethod,
            ':function' => $calledCodeDto->function,
            ':location' => $calledCodeDto->location,
            ':server_name' => $calledCodeDto->serverName,
            ':server_ip' => $calledCodeDto->serverIp,
            ':app_name' => $calledCodeDto->appName,
            ':env' => $calledCodeDto->env,
            ':client_ip' => $calledCodeDto->clientIp,
            ':accessed_at' => $calledCodeDto->accessedAt,
        ]);
    }
}
