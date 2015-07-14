<?php
// Pull in bootstrap
require dirname(__DIR__) . '/bootstrap.php';

// Check args
if ($argc !== 2) {
    echo 'USAGE: php add-boomark.php https://www.oreilly.com' . PHP_EOL;
    exit;
}

// Get URL
$url = $argv[1];

// Create bookmark manager
$manager = new \App\BookmarkManager($pdo);

// Create bookmark
$embedly = new \Embedly\Embedly(['key' => $settings['embedlyKey']]);
$bookmark = new \App\BookmarkEmbedly($url, $embedly);

// Add bookmark to manager
if ($manager->addBookmark($bookmark)) {
    echo 'Success!' . PHP_EOL;
} else {
    echo 'Fail!' . PHP_EOL;
}
