<?php

function findDeadCodeCheckLocations($path) {
    $output = array();

    exec('grep -rn "\->checkForDeadCode\(\)" ' . $path, $output);

    return array_map(function ($grepResult) use ($path) {
        $stripped = str_replace($path, '', $grepResult);
        $parts = explode(':', $stripped);
        return implode(':', [$parts[0], $parts[1]]);
    }, $output);
}

$pdo = new PDO(
    'mysql:dbname=deadcode;host=127.0.0.1;port=3306;charset=utf8',
    'root',
    'my-secret-pw'
);

function truncationCurrentLocations() {
    global $pdo;
    $pdo->exec('TRUNCATE code_check_locations');
}

function insertLocation($location) {
    global $pdo;
    $stmt = $pdo->prepare('INSERT INTO code_check_locations VALUE (:location)');
    $stmt->execute(['location' => $location]);
}

if (isset($argv[1]) === false) {
    echo "Path to the PHP codebase must be provided\n";
    exit(1);
}

if (is_dir($argv[1]) === false) {
    echo "Path to the PHP codebase must be valid\n";
    exit(1);
}

$deadCodeCheckLocations = findDeadCodeCheckLocations($argv[1]);

truncationCurrentLocations();

foreach ($deadCodeCheckLocations as $location) {
    insertLocation($location);
    echo "Added Dead Code Location: $location \n";
}
