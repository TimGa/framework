<?php

namespace Framework\Http;

use Psr\Http\Message\ServerRequestInterface;

/**
 * Description of Request
 *
 * @author timofey
 */
class Request implements ServerRequestInterface
{   
    private $queryParams;
    private $parsedBody;
    
    public function __construct(array $queryParams = [], array $parsedBody = [])
    {
        $this->queryParams = $queryParams;
        $this->parsedBody = $parsedBody;
    }
    
    public function getQueryParams(): array
    {
        return $this->queryParams;
    }
    
    public function getParsedBody(): ?array
    {
        return $this->parsedBody;
    }
    
    public function withQueryParams(array $queryParams): self
    {
        $newRequest = clone $this;
        $newRequest->queryParams = $queryParams;
        return $newRequest;
    }
    
    public function withParsedBody($data)
    {
        $newRequest = clone $this;
        $newRequest->parsedBody = $data;
        return $newRequest;
    }
    
    public function getAttribute($name, $default = null){}
    public function getAttributes(){}
    public function getBody(){}
    public function getCookieParams(){}
    public function getHeader($name){}
    public function getHeaderLine($name){}
    public function getHeaders(){}
    public function getMethod(){}
    public function getProtocolVersion(){}
    public function getRequestTarget(){}
    public function getServerParams(){}
    public function getUploadedFiles(){}
    public function getUri(){}
    public function hasHeader($name){}
    public function withAddedHeader($name, $value){}
    public function withAttribute($name, $value){}
    public function withBody(\Psr\Http\Message\StreamInterface $body){}
    public function withCookieParams(array $cookies){}
    public function withHeader($name, $value){}
    public function withMethod($method){}
    public function withProtocolVersion($version){}
    public function withRequestTarget($requestTarget){}
    public function withUploadedFiles(array $uploadedFiles){}
    public function withUri(\Psr\Http\Message\UriInterface $uri, $preserveHost = false){}
    public function withoutAttribute($name){}
    public function withoutHeader($name){}

}
