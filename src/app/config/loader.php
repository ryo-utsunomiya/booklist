<?php

$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader
    ->registerDirs([
        $config->application->controllersDir,
        $config->application->modelsDir
    ])->registerNamespaces([
        'Booklist\Controller' => APP_PATH . '/app/controllers',
        'Booklist\Model'      => APP_PATH . '/app/models',
    ])->register();