<?php

use Framework\Http\RequestFactory;
use Framework\Http\Response;

chdir(dirname(__DIR__));
require_once 'vendor/autoload.php';

$request = RequestFactory::fromGlobals()->withParsedBody([1,2,3]);

$name = $request->getQueryParams()['name'] ?? "Guest";
$body = "Hello, $name!" . "<br>";

$response = (new Response())
        ->withHeader('X-h1', 'h1')
        ->withHeader('X-h2', 'h2')
        ->withHeader('X-h1', ['h1', 'additional-h1'])
        ->withStatus(200)
        ->withBody($body);

header('HTTP/1.1 ' . $response->getStatusCode() . ' ' . $response->getReasonPhrase());
foreach ($response->getHeaders() as $name => $values) {
    header($name . ': ' . implode(', ', $values));
}
echo $response->getBody();