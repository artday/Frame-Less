<?php

use Dotenv\Exception\InvalidPathException;

session_start();

require_once __DIR__ . '/../vendor/autoload.php';

try {
    $dotenv = (new \Dotenv\Dotenv(base_path()))->load();
} catch (InvalidPathException $e) {
    echo "<br>There is no ENV  were find<br>";
}