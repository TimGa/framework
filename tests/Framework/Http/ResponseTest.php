<?php

namespace Tests\Framework\Http;

use PHPUnit\Framework\TestCase;
use Framework\Http\Response;

/**
 * Description of ResponseTest
 *
 * @author timofey
 */
class ResponseTest extends TestCase
{
    public function testEmpty(): void
    {
        $response = new Response($body = 'body');
        
        self::assertEquals($body, $response->getBody());
        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals('OK', $response->getReasonPhrase());
        self::assertEquals([], $response->getHeaders());
    }
    
    public function test404(): void
    {
        $response = new Response($body = 'empty', 404);
        
        self::assertEquals($body, $response->getBody());
        self::assertEquals(404, $response->getStatusCode());
        self::assertEquals('Not Found', $response->getReasonPhrase());
    }
    
    public function testHeaders(): void
    {
        $response = (new Response())
            ->withHeader('X-Header-1', 'h1')
            ->withHeader($name1 = 'X-Header-2', $value1 = 'h2')
            ->withHeader($name2 = 'X-Header-1', $value2 = 'replaced-h1');
        $expected = [
            'X-Header-2' => ['h2'],
            'X-Header-1' => ['replaced-h1'],
        ];
        self::assertEquals($expected, $response->getHeaders());
        self::assertEquals([$value1], $response->getHeader($name1));
        self::assertEquals([$value2], $response->getHeader($name2));
        self::assertNull($response->getHeader('notexists'));
    }
}
