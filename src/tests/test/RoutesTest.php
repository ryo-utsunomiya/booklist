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
        $router = $this->getDI()->get('router');

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
            ['/books/rate', 'books', 'rate'], // Books::rate
        ];
    }
}
 