<?php

namespace Initium;

require __DIR__ . '/../vendor/autoload.php';
\AaronHolbrook\Autoload\autoload( __DIR__ . '/../app/config' );
require  __DIR__ . '/../vendor/verot/class.upload.php/src/class.upload.php';

$dispatcher = \FastRoute\simpleDispatcher(function(\FastRoute\RouteCollector $r) {
   
    $r->get('/test2/{tid:\d+}',['\Initium\Test','test_instance']);

});


// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);
$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case \FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        //sleep(5);
        header("HTTP/1.0 404 Not Found");
        break;
    case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        //sleep(5);
        header("HTTP/1.0 405 Method Not Allowed");
        break;
    case \FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        $class = new $handler[0];
        $class->{$handler[1]}($vars);    
        break;
}
