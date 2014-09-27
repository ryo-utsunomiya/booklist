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
            ['/', '', ''], // Index::index
            ['/books/add', 'books', 'add'], // Books::add
        ];
    }
}
 