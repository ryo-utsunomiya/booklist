<?php
use Phalcon\DI,
    \Phalcon\Test\UnitTestCase as PhalconTestCase;

abstract class UnitTestCase extends PhalconTestCase
{

    protected $_cache;

    /**
     * @var \Phalcon\Config
     */
    protected $_config;

    /**
     * @param \Phalcon\DiInterface $di
     * @param \Phalcon\Config      $config
     */
    public function setUp(\Phalcon\DiInterface $di = null, \Phalcon\Config $config = null)
    {
        // Load any additional services that might be required during testing
        $di = DI::getDefault();

        // get any DI components here. If you have a config, be sure to pass it to the parent

        parent::setUp($di);
    }
}