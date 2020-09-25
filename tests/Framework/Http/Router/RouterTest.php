<?php

namespace Tests\Framework\Http\Router;

use PHPUnit\Framework\TestCase;
use Framework\Http\Router\RouteCollection;
use Framework\Http\Router\Router;
use Framework\Http\Router\Exception\RequestNotMachedException;
use Laminas\Diactoros\ServerRequest;
use Laminas\Diactoros\Uri;

/**
 * Description of RouterTest
 *
 * @author timofey
 */
class RouterTest extends TestCase
{
    public function testCorrectMethod()
    {
        $routes = new RouteCollection();
        $routes->get('get_note', '/note', 'handler_for_get');
        $routes->post('edit_note', '/note', 'handler_for_post');
        
        $router = new Router($routes);
        
        $result = $router->match($this->buildRequest('GET', '/note'));
        self::assertEquals('get_note', $result->getName());
        self::assertEquals('handler_for_get', $result->getHandler());
        
        $result = $router->match($this->buildRequest('POST', '/note'));
        self::assertEquals('edit_note', $result->getName());
        self::assertEquals('handler_for_post', $result->getHandler());
    }
    
    public function testMissingRouteMethod()
    {
        $routes = new RouteCollection();
        $routes->get('get_note', '/note', 'handler_for_get');
        
        $router = new Router($routes);
        
        $this->expectException(RequestNotMachedException::class);
        $router->match($this->buildRequest('DELETE', '/note'));
    }
    
    public function testCorrectAttributes()
    {
        $routes = new RouteCollection();
        $routes->get('get_note', '/note/{id}', 'handler', ['id' => '\d+']);
        
        $router = new Router($routes);
        
        $result = $router->match($this->buildRequest('GET', '/note/23'));
        
        self::assertEquals('get_note', $result->getName());
        self::assertEquals(['id' => '23'], $result->getAttributes());
    }
    
    public function testIncorrectAtributes()
    {
        $routes = new RouteCollection();
        $routes->get('get_note', '/note/{id}', 'handler', ['id' => '\d+']);
        
        $router = new Router($routes);
        
        $this->expectException(RequestNotMachedException::class);
        $router->match($this->buildRequest('GET', '/note/not_numeric_id'));
    }
    
    public function testGenerate()
    {
        $routes = new RouteCollection();
        $routes->get('note_index', '/note', 'index_handler');
        $routes->get('note_show', '/note/{id}', 'show_handler', ['id' => '\d+']);
        
        $router = new Router($routes);
        
        self::assertEquals('/note', $router->generate('note_index'));
        self::assertEquals('/note/23', $router->generate('note_show', ['id' => '23']));
    }
    
    public function testGenerateInvalidArguments()
    {
        $routes = new RouteCollection();
        $routes->get('note_show', '/note/{id}', 'show_handler', ['id' => '\d+']);
        
        $router = new Router($routes);
        
        $this->expectException(\InvalidArgumentException::class);
        $router->generate('note_show', ['id' => 'incorrect_id']);
    }
    
    private function buildRequest($method, $path)
    {
        return (new ServerRequest())
            ->withUri(new Uri($path))
            ->withMethod($method);
    }
}
