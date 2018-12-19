<?php

use Dotenv\Dotenv;
use App\Views\View;
use App\Exceptions\Handler;
use App\Session\SessionStore;
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

require_once base_path('bootstrap/middleware.php');

require_once base_path('routes/web.php');

try {
    $response = $route->dispatch(
        $container->get('request'), $container->get('response')
    );

} catch (Exception $e) {
    $handler = new Handler(
        $e,
        $container->get(SessionStore::class),
        $container->get('response'),
        $container->get(View::class)
    );
    $response = $handler->respond();
}