<?php

error_reporting(E_ALL);

define('APP_PATH', realpath(__DIR__ . '/../'));

try {

    $config = require __DIR__ . "/../app/config/config.php";

    (new Phalcon\Loader())
        ->registerDirs([
            $config->application->controllersDir,
            $config->application->modelsDir,
        ])->registerNamespaces([
            'Booklist\Controller' => APP_PATH . '/app/controllers',
            'Booklist\Model'      => APP_PATH . '/app/models',
        ])->register();

    $di = require __DIR__ . "/../app/config/services.php";

    echo (new Phalcon\Mvc\Application($di))->handle()->getContent();

} catch (\Exception $e) {
    echo $e->getMessage();
}

function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
