<?php
// Pull in bootstrap
require dirname(__DIR__) . '/bootstrap.php';

// Check args
if ($argc !== 3) {
    echo 'USAGE: php add-user.php johnSmith password' . PHP_EOL;
    exit;
}

// Get URL
$username = $argv[1];
$password = $argv[2];

// Create password hash
$hash = password_hash(
    $password,
    PASSWORD_DEFAULT,
    ['cost' => $settings['costFactor']]
);

// Create bookmark
$stmt = $pdo->prepare('INSERT INTO users (username, password) VALUES (:username, :password)');
$stmt->bindValue(':username', $username);
$stmt->bindValue(':password', $hash);
if ($stmt->execute()) {
    echo 'Success' . PHP_EOL;
} else {
    echo 'Fail!' . PHP_EOL;
}