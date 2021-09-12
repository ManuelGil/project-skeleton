<?php

include __DIR__ . './../vendor/autoload.php';

use App\Controllers\AuthenticationController;
use App\Controllers\DashboardController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

if ($_ENV['ENVIRONMENT'] != "production") {
    // Show errors
    error_reporting(-1);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
}

// Start session
session_start();

// Create a server request object form global variables of PHP.
//    $_SERVER
//    $_GET
//    $_POST
//    $_COOKIE
//    $_FILES
$request = Request::createFromGlobals();

// Get a context of request.
$context = new RequestContext();
$context->fromRequest($request);

// Create the router container and get the routing map.
$routes = new RouteCollection();

// Add the routes to the map, and a handler for it.
$routes->add('index', new Route(
    '/',
    [
        'controller' => AuthenticationController::class,
        'method' => 'getLogin',
    ]
));
$routes->add('login', new Route(
    '/login',
    [
        'controller' => AuthenticationController::class,
        'method' => 'postLogin',
    ]
));
$routes->add('home', new Route(
    '/home',
    [
        'controller' => DashboardController::class,
        'method' => 'getIndex',
    ]
));
$routes->add('logout', new Route(
    '/logout',
    [
        'controller' => AuthenticationController::class,
        'method' => 'getLogout',
    ]
));

try {
    // Get the route matcher from the container ...
    $matcher = new UrlMatcher($routes, $context);
    $route = $matcher->match($context->getPathInfo());

    // Dispatch the request to the route handler.
    $controller = new $route['controller'];
    $method = $route['method'];
    $response = $controller->$method($request);
} catch (ResourceNotFoundException $exception) {
    $response = new Response('Not Found', 404);
} catch (Throwable $throwable) {
    $response = new Response('An error occurred', 500);
}

// Emit the response
http_response_code($response->getStatusCode());
echo $response->getContent();
