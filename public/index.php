<?php

use Psr\Http\Message\ServerRequestInterface;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Framework\Http\Router\RouteCollection;
use Framework\Http\Router\Router;
use Framework\Http\Router\Exception\RequestNotMachedException;

chdir(dirname(__DIR__));
require_once 'vendor/autoload.php';

$routes = new RouteCollection();

$routes->get('home', '/', function (ServerRequestInterface $request) {
    $name = $request->getQueryParams()['name'] ?? 'Guest';
    $body = sprintf('Hello %s', $name);
    return new HtmlResponse($body);
});

$routes->get('about', '/about', function () {
    return new HtmlResponse('about page');
});

$routes->get('note_show', '/note/{id}', function (ServerRequestInterface $request) {
    $id = $request->getAttribute('id');
    $body = sprintf('note #%s', $id);
    return new HtmlResponse($body);
}, ['id' => '\d+']);

$request = ServerRequestFactory::fromGlobals();
$router = new Router($routes);
try {
    $result = $router->match($request);
    foreach ($result->getAttributes() as $attribute => $value) {
        $request = $request->withAttribute($attribute, $value);
    }
    $action = $result->getHandler();
    $response = $action($request);
} catch (RequestNotMachedException $e) {
    $response = new HtmlResponse('not found 404 error', 404);
}

$emitter = new SapiEmitter();
$emitter->emit($response);
