<?php

error_reporting(E_ALL);

define('APP_PATH', realpath(__DIR__ . '/../'));

require_once APP_PATH . '/app/library/functions.php';

try {

    $config = get_config();

    (new Phalcon\Loader())
        ->registerDirs([
            $config->application->controllersDir,
            $config->application->modelsDir,
        ])->registerNamespaces([
            'Booklist\Controller'      => APP_PATH . '/app/controllers',
            'Booklist\Model'           => APP_PATH . '/app/models',
            'Booklist\Model\Validator' => APP_PATH . '/app/models/validators',
        ])->register();

    $di = require __DIR__ . "/../app/config/services.php";

    echo (new Phalcon\Mvc\Application($di))->handle()->getContent();

} catch (\Exception $e) {
    echo $e->getMessage();
}
