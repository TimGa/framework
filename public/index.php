<?php

use Framework\Http\RequestFactory;
use Framework\Http\Response;

chdir(dirname(__DIR__));
require_once 'vendor/autoload.php';

$request = RequestFactory::fromGlobals()->setParsedBody([1,2,3]);

$name = $request->getQueryParams()['name'] ?? "Guest";
$body = "Hello, $name!" . "<br>";


$response = (new Response($body))
        ->setHeader('X-h1', 'h1')
        ->setHeader('X-h2', 'h2')
        ->setHeader('X-h1', 'replaced-h1')
        ->setStatus(200);

header('HTTP/1.1 ' . $response->getStatusCode() . ' ' . $response->getReasonPhrase());
foreach ($response->getHeaders() as $name => $value) {
    header("$name: $value");
}
echo $response->getBody();