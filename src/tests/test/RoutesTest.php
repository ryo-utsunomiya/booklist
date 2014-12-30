<?php

namespace Test;

/**
 * Class RoutesTest
 * @package Test
 */
class RoutesTest extends \UnitTestCase
{
    /**
     * @test
     * @dataProvider Test\RoutesTest::routerProvider
     *
     * @param $url
     * @param $controller
     * @param $action
     */
    public function router($url, $controller, $action)
    {
        /** @var \Phalcon\Mvc\Router $router */
        $router = require APP_PATH . '/app/config/routes.php';

        $router->handle($url);

        $this->assertEquals($controller, $router->getControllerName());
        $this->assertEquals($action, $router->getActionName());
    }

    /**
     * @return array
     */
    public function routerProvider()
    {
        return [
            ['/', 'index', 'index'], // Index::index
            ['/books/new', 'books', 'new'], // Books::new
            ['/books/1/detail', 'books', 'detail'], // Books::detail
            ['/books/1/rate/plus', 'books', 'rate'], // Books::rate
            ['/books/1/delete', 'books', 'delete'], // Books::delete
            ['/api/books', 'books', 'index']
        ];
    }
}
 