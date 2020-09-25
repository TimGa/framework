<?php

namespace Framework\Http\Router;

class Route
{

    private $name;
    private $handler;
    private $methods;
    private $tokens;
    private $pattern;

    public function __construct(string $name, string $pattern, $handler, array $methods, array $tokens = [])
    {
        $this->name = $name;
        $this->pattern = $pattern;
        $this->handler = $handler;
        $this->methods = $methods;
        $this->tokens = $tokens;
    }
    
    public function getName(): string
    {
        return $this->name;
    }
    
    /**
     * @return mixed
     */
    public function getHandler()
    {
        return $this->handler;
    }

    public function getMethods(): array
    {
        return $this->methods;
    }

    public function getTokens(): array
    {
        return $this->tokens;
    }

    public function getPattern(): string
    {
        return $this->pattern;
    }



}
