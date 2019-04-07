<?php

use Dotenv\Dotenv;
use App\Views\View;
use App\Exceptions\Handler;
use App\Session\SessionStore;
use Dotenv\Exception\InvalidPathException;
use App\Core\Framework\Route\RouteCollection;

session_start();

// declare function base_path() outside helpers
if (!function_exists('base_path')) {
    function base_path($path = '') {
        return __DIR__ . '/..//' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}

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

// must require helpers after routes because route(name) method requires global $route
require_once base_path('app/helpers.php');

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