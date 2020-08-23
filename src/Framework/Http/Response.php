<?php

namespace Framework\Http;

use Psr\Http\Message\ResponseInterface;

/**
 * Description of Response
 *
 * @author timofey
 */
class Response implements ResponseInterface
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
    
    public function withBody($body): self
    {
        $newResponse = clone $this;
        $newResponse->body = $body;
        return $newResponse;
    }
    
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
    
    public function withStatus($code, $phrase = '')
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
    
    public function hasHeader($name): bool
    {
        return isset($this->headers[$name]);
    }
    
    public function getHeader($name): ?array
    {
        return $this->hasHeader($name) ? $this->headers[$name] : null;
    }
    
    public function withHeader($name, $value): self
    {
        $newResponse = clone $this;
        if ($newResponse->hasHeader($name)) {
            unset($newResponse->headers[$name]);
        }
        $newResponse->headers[$name] = is_array($value) ? $value : [$value];
        return $newResponse;
    }
    
    public function getHeaderLine($name){}
    public function getProtocolVersion(){}
    public function withAddedHeader($name, $value){}
    public function withProtocolVersion($version){}
    public function withoutHeader($name){}
    
}
