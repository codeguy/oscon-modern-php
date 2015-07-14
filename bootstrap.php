<?php
// Composer autoloader
require __DIR__ . '/vendor/autoload.php';

// App settings
$settings = [
    'dbhost' => '192.168.33.10',
    'dbuser' => 'demo',
    'dbpass' => 'demo',
    'dbname' => 'demo',
    'embedlyKey' => '85a6d1b135ec47da97e651c0ee730b3f',
    'costFactor' => 10
];

// Database connection
try {
    $pdo = new \PDO(
        sprintf(
            'mysql:host=%s;dbname=%s',
            $settings['dbhost'],
            $settings['dbname']
        ),
        $settings['dbuser'],
        $settings['dbpass']
    );
} catch (\PDOException $e) {
    echo 'Database connection failed!';
    exit;
}
