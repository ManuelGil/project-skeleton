<?php

include __DIR__ . './../vendor/autoload.php';

use App\Models\UserModel;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
$routes->add('index', new Route('/', ['handler' => function (Request $request) {
    return new Response(require '../app/views/index.php', 200);
}]));
$routes->add('login', new Route('/login', ['handler' => function (Request $request) {
    $username = $request->request->get('username');
    $password = $request->request->get('password');

    $userModel = new UserModel();
    $user = $userModel->findByUsername($username);

    if ($user && password_verify($password, $user->password)) {
        $_SESSION['login'] = true;
        $_SESSION['id'] = $user->id;

        return new RedirectResponse('/home', 302);
    } else {
        $_SESSION['message'] = "Bad credentials";

        return new RedirectResponse('/', 302);
    }
}]));
$routes->add('home', new Route('/home', ['handler' => function (Request $request) {
    if (!$_SESSION['login']) {
        return new RedirectResponse('/', 302);
    }

    $userModel = new UserModel();
    $user = $userModel->findById($_SESSION['id']);

    return new Response(require '../app/views/home.php', 200);
}]));
$routes->add('logout', new Route('/logout', ['handler' => function (Request $request) {
    unset($_SESSION['login']);
    unset($_SESSION['id']);
    session_destroy();

    return new RedirectResponse('/', 302);
}]));

try {
    // Get the route matcher from the container ...
    $matcher = new UrlMatcher($routes, $context);
    $route = $matcher->match($context->getPathInfo());

    // Dispatch the request to the route handler.
    $callable = $route['handler'];
    $response = $callable($request);
} catch (ResourceNotFoundException $exception) {
    $response = new Response('Not Found', 404);
} catch (Throwable $throwable) {
    $response = new Response('An error occurred', 500);
}

// Emit the response
http_response_code($response->getStatusCode());
echo $response->getContent();
