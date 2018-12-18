<?php

use Dotenv\Dotenv;
use League\Route\RouteCollection;
use Dotenv\Exception\InvalidPathException;

session_start();

require_once __DIR__ . '/../vendor/autoload.php';

try {
    $dotenv = (new Dotenv(base_path()))->load();
} catch (InvalidPathException $e) {
    echo "<br>There is no ENV  were find<br>";
}

require_once base_path('bootstrap/container.php');

$route = $container->get(RouteCollection::class);

require_once base_path('routes/web.php');

$response = $route->dispatch(
    $container->get('request'), $container->get('response')
);

$response = $response->respond();