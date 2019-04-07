<?php

use Zend\Diactoros\Response\RedirectResponse;

if (!function_exists('redirect')) {
    function redirect($path) {
        return new RedirectResponse($path);
    }
}

if (!function_exists('route')) {
    function route($name, array $args = []) {
        global $route;
        return $route->getNamedRoute($name)->getPath($args);
    }
}

if (!function_exists('random_string')) {
    function random_string($length = 32) {
        $rand = '';
        while ($length) {
            $rand .= rand(0, 9);
            $length--;
        }
        return bin2hex(base64_encode($rand));
    }
}

if (!function_exists('base_path')) {
    function base_path($path = '') {
        return __DIR__ . '/..//' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}

if (!function_exists('env')) {
    function env($key, $default = null) {
        $value = getenv($key);

        if($value === false) {
            return $default;
        }

        switch (strtolower($value)) {
            case $value === 'true';
                return true;
            case $value === 'false';
                return false;
            default:
                return $value;
        }
    }
}

/*TODO: delete setter below if not needed
 * */
if (!function_exists('config')) {
    function config($key = null, $default = null) {
        global $container;

        if (is_null($key)) {
            return $container->get('config');
        }

        // set if config(['$key', '$val'])
        /*if (is_array($key)) {
            return app('config')->set($key);
        }*/

        return $container->get('config')->get($key, $default);
    }
}