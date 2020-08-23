<?php

namespace Framework\Http;

/**
 * Description of Response
 *
 * @author timofey
 */
class Response
{
    private $body;
    private $statusCode;
    private $reasonPhrase;
    private $headers = [];
    private static $phrases = [
        200 => 'OK',
        404 => 'Not Found',
        
    ];
    
    public function __construct($body = null, $statusCode = 200)
    {
        $this->body = $body;
        $this->statusCode = $statusCode;
    }
    
    public function getBody(): string
    {
        return $this->body;
    }
    
    public function setBody($body): self
    {
        $newResponse = clone $this;
        $newResponse->body = $body;
        return $newResponse;
    }
    
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
    
    public function setStatus(int $code, string $phrase = ''): self
    {
        $newResponse = clone $this;
        $newResponse->statusCode = $code;
        $newResponse->reasonPhrase = $phrase;
        return $newResponse;
        
    }
    
    public function getHeaders(): array
    {
        return $this->headers;
    }
    
    public function getReasonPhrase(): string
    {
        if (!$this->reasonPhrase && isset(self::$phrases[$this->statusCode])) {
            $this->reasonPhrase = self::$phrases[$this->statusCode];
        }
        return $this->reasonPhrase;
    }
    
    public function hasHeader(string $name): bool
    {
        return isset($this->headers[$name]);
    }
    
    public function getHeader(string $name): ?string
    {
        return $this->hasHeader($name) ? $this->headers[$name] : null;
    }
    
    public function setHeader(string $name, string $value): self
    {
        $newResponse = clone $this;
        if ($newResponse->hasHeader($name)) {
            unset($newResponse->headers[$name]);
        }
        $newResponse->headers[$name] = $value;
        return $newResponse;
    }
}
