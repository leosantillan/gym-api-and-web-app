<?php 

declare(strict_types = 1);

namespace VirtuaGym;

require __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Router;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;

$dotenv = new \Dotenv\Dotenv(__DIR__ . '/..');
$dotenv->load();

if (getenv('ENVIRONMENT') === 'development') {
    error_reporting(E_ALL);
}

$injector = include('Dependencies.php');

$request = $injector->make('Symfony\Component\HttpFoundation\Request');
$response = $injector->make('Symfony\Component\HttpFoundation\Response');

// Routing
$fileLocator = new FileLocator(array(__DIR__ . getenv('ROUTING_PATH')));
$requestContext = new RequestContext();
$requestContext->fromRequest(Request::createFromGlobals());
$router = new Router(
    new YamlFileLoader($fileLocator),
    getenv('ROUTING_FILE'),
    [],
    $requestContext
);

$routes = $router->getRouteCollection();
$matched = $router->match($requestContext->getPathInfo());

try {
    $request->attributes->add($matched);
    $controller = explode('::', $request->get('_controller'));
    $obj = $injector->make($controller[0]);
    $injector->execute([$obj, $controller[1]]);
} catch (Routing\Exception\ResourceNotFoundException $exception) {
    $response = new Response('Not Found', 404);
} catch (Exception $exception) {
    $response = new Response('An error occurred', 500);
}

if ($response !== null) {
    $response->send();
}
