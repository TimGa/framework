<?php

namespace Tests\Framework\Http;

use PHPUnit\Framework\TestCase;
use Framework\Http\RequestFactory;
use Framework\Http\Request;

/**
 * Description of RequestFactoryTest
 *
 * @author timofey
 */
class RequestFactoryTest extends TestCase
{
    public function testCreationFromGlobals()
    {
        $query = [
            'name' => 'Bob',
            'age' => 55,
        ];
        $body = [1, 2, 3];
        
        $request = RequestFactory::fromGlobals($query, $body);
        
        self::assertInstanceOf(Request::class, $request);
        self::assertEquals($query, $request->getQueryParams());
        self::assertEquals($body, $request->getParsedBody());
    }
    
    public function testCreationFromGlobalsEmpty()
    {
        $request = RequestFactory::fromGlobals();
        
        self::assertInstanceOf(Request::class, $request);
        self::assertEquals([], $request->getQueryParams());
        self::assertEquals([], $request->getParsedBody());
    }
}
