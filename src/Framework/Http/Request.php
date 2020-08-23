<?php

namespace Framework\Http;

/**
 * Description of Request
 *
 * @author timofey
 */
class Request
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
    
    public function setQueryParams(array $queryParams): self
    {
        $newRequest = clone $this;
        $newRequest->queryParams = $queryParams;
        return $newRequest;
    }
    
    public function setParsedBody(array $parsedBody = []): self
    {
        $newRequest = clone $this;
        $newRequest->parsedBody = $parsedBody;
        return $newRequest;
    }
}
