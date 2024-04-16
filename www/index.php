<?php

namespace Initium;

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require __DIR__ . '/../vendor/autoload.php';
\AaronHolbrook\Autoload\autoload( __DIR__ . '/../app/config' );
require  __DIR__ . '/../vendor/verot/class.upload.php/src/class.upload.php';

$dispatcher = \FastRoute\simpleDispatcher(function(\FastRoute\RouteCollector $r) {
   
    $r->get('/',['\Initium\User','home_page']);
    $r->get('/logout',['\Initium\User','logout_page']);
    $r->get('/login',['\Initium\User','login_page']);
    $r->post('/login',['\Initium\User','login']);
    $r->get('/logged-in-page',['\Initium\User','logged_in_page']);
    $r->get('/create-account',['\Initium\User','create_account_page']);
    $r->post('/create-account',['\Initium\User','create_account']);
    $r->get('/password-forgot',['\Initium\User','forgot_password_page']);
    $r->post('/password-forgot',['\Initium\User','forgot_password']);
    $r->get('/password-reset/{pass_uuid}',['\Initium\User','reset_password_page']);
    $r->post('/password-reset/{pass_uuid}',['\Initium\User','reset_password']);

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
        // session timeouts
        ini_set('session.gc_maxlifetime', 3600 * LOGIN_TIMEOUT);
        session_set_cookie_params(3600 * LOGIN_TIMEOUT);
        session_start();
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        $class = new $handler[0];
        $class->{$handler[1]}($vars);    
        break;
}
