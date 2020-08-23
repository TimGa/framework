<?php

namespace Tests\Framework\Http;

use PHPUnit\Framework\TestCase;
use Framework\Http\Request;

/**
 * Description of RequestTest
 *
 * @author timofey
 */
class RequestTest extends TestCase
{
    public function testEmpty(): void
    {
        $request = new Request();
        
        self::assertEquals([], $request->getQueryParams());
        self::assertEquals([], $request->getParsedBody());
    }
    
    public function testQueryParams(): void
    {
        $queryParams = [
            'name' => 'tim',
            'age' => 30,
        ];
      
        $request = (new Request())->setQueryParams($queryParams);
        
        self::assertEquals($queryParams, $request->getQueryParams());
        self::assertEquals([], $request->getParsedBody());
    }
    
    public function testParsedBody(): void
    {
        $parsedBody = [
            'test_post_field' => 'test_post_field_data',
        ];
        
        $request = (new Request())->setParsedBody($parsedBody);
        
        self::assertEquals([], $request->getQueryParams());
        self::assertEquals($parsedBody, $request->getParsedBody());
    }
}
