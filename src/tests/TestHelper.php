<?php
use Phalcon\DI,
    Phalcon\DI\FactoryDefault;

ini_set('display_errors', 1);
error_reporting(E_ALL);

define('APP_PATH', realpath(__DIR__ . '/../'));
define('ROOT_PATH', __DIR__);
define('PATH_LIBRARY', __DIR__ . '/../app/library/');
//define('PATH_SERVICES', __DIR__ . '/../app/services/');
//define('PATH_RESOURCES', __DIR__ . '/../app/resources/');

set_include_path(
    ROOT_PATH . PATH_SEPARATOR . get_include_path()
);

// required for phalcon/incubator
include __DIR__ . "/../vendor/autoload.php";

// use the application autoloader to autoload the classes
// autoload the dependencies found in composer
$loader = new \Phalcon\Loader();

$loader->registerDirs(array(
    ROOT_PATH
));

$loader->registerNamespaces([
    'Booklist\Controller' => APP_PATH . '/app/controllers',
    'Booklist\Model'      => APP_PATH . '/app/models',
]);

$loader->register();

$di = new FactoryDefault();
DI::reset();

// add any needed services to the DI here

$config = require APP_PATH . '/app/config/config.php';

$di->setShared('db', function () use ($config) {
    return new Phalcon\Db\Adapter\Pdo\Mysql([
        'dsn'      => $config->database->dsn,
        'username' => $config->database->username,
        'password' => $config->database->password,
    ]);
});

DI::setDefault($di);