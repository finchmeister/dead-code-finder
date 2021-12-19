<?php

$pdo = new PDO(
    'mysql:dbname=deadcode;host=127.0.0.1;port=3306;charset=utf8',
    'root',
    'my-secret-pw'
);

$stmt = $pdo->prepare("SELECT ccl.location, max(accessed_at) as 'last_accessed' FROM code_check_locations ccl
                                          LEFT JOIN called_code cc ON ccl.location = cc.location GROUP BY ccl.location;");

$stmt->execute();

foreach ($stmt->fetchAll() as $result) {
    echo sprintf("%s --- %s \n", $result['location'], $result['last_accessed'] !== null ? '✅' : '💀');
}