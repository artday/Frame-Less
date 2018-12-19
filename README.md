## FrameLess Framework
<p>Project structure includes: routing, service providers, powerful database integration, authentication, 
validation, flash messages and so much more.</p>

## Server Requirements
<p>PHP >= 5.6</p>

## Routing
<p><pre>$route->get('foo', function () {
       return 'Hello World';
});</pre></p>

## Named Routes
<p><pre>$route->get('/', 'HomeController::index')->setName('home');</pre></p>

## Route Groups
<p><pre>
$route->group('', function ($route) {
    $route->get('/auth/signin', 'App\Controllers\Auth\LoginController::index')->setName('auth.login');
    $route->post('/auth/signin', 'App\Controllers\Auth\LoginController::signin');
    $route->get('/auth/register', 'App\Controllers\Auth\RegisterController::index')->setName('auth.register');
    $route->post('/auth/register', 'App\Controllers\Auth\RegisterController::register');
})->middleware($container->get(App\Middleware\Guest::class));
</pre></p>


