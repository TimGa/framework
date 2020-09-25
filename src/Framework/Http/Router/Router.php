<?php

namespace Framework\Http\Router;

use \Psr\Http\Message\ServerRequestInterface;
use \Framework\Http\Router\Exception\RouteNotFoundException;
use \Framework\Http\Router\Exception\RequestNotMachedException;

class Router
{
    private $routes;
    
    public function __construct(RouteCollection $routes)
    {
        $this->routes = $routes;
    }
    
    public function match(ServerRequestInterface $request): Result
    {

        foreach ($this->routes->getRoutes() as $route) {
            
            if (
                $route->getMethods() 
                && ! in_array($request->getMethod(), $route->getMethods(), true)
            ) {
                continue;
            }

            $pattern = preg_replace_callback('~\{([^\}]+)\}~', function ($matches) use ($route) {
                $argument = $matches[1];
                $replace = $route->getTokens()[$argument] ?? '[^}]+';
                return '(?P<' . $argument . '>' . $replace . ')';
            }, $route->getPattern());
            
            if (preg_match('~^' . $pattern . '$~i', $request->getUri()->getPath(), $matches)) {
                return new Result(
                    $route->getName(),
                    $route->getHandler(),
                    array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY)
                );
            }
        }
        
        throw new RequestNotMachedException($request);
    }
    
    public function generate(string $name, array $params = []): string
    {
        foreach ($this->routes->getRoutes() as $route) {
            
            if ($route->getName() !== $name) {
                continue;
            }
            
            $url = preg_replace_callback('~\{([^\}]+)\}~', function ($matches) use ($params, $route) {
                $argument = $matches[1];
                if (!array_key_exists($argument, $params)) {
                    throw new \InvalidArgumentException('Missing parameter "' . $argument . '".');
                }
                $paramValue = $params[$argument];
                $tokenPattern = $route->getTokens()[$argument] ?? '[^}]+';
                if (! preg_match('~^' . $tokenPattern . '$~i', $paramValue)) {
                    $message = sprintf(
                        'Parameter value "%s" not matches to token pattern "%s".',
                        $paramValue,
                        $tokenPattern
                    );
                    throw new \InvalidArgumentException($message);
                }
                return $paramValue;
            }, $route->getPattern());
            
            if ($url !== null) {
                return $url;
            }
        }
        
        throw new RouteNotFoundException($name, $params);
    }
}
