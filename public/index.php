<?php

use Laminas\Diactoros\ServerRequestFactory;
use Laminas\Diactoros\Response;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;

chdir(dirname(__DIR__));
require_once 'vendor/autoload.php';

$request = ServerRequestFactory::fromGlobals();
$name = $request->getQueryParams()['name'] ?? "Guest";
$body = "Hello, $name!" . "<br>";

$response = (new Response())
        ->withHeader('X-h1', 'h1')
        ->withHeader('X-h2', 'h2')
        ->withAddedHeader('X-h1', 'added-h1')
        ->withStatus(222, 'tim-phrase');

$response->getBody()->write($body);

$emitter = new SapiEmitter();
$emitter->emit($response);
