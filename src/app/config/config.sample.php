<?php

return new \Phalcon\Config(array(
    'database'    => array(
        'dsn'      => 'mysql:host=localhost;dbname=booklist;charset=utf8',
        'username' => '',
        'password' => '',
    ),
    'application' => array(
        'controllersDir' => __DIR__ . '/../../app/controllers/',
        'modelsDir'      => __DIR__ . '/../../app/models/',
        'viewsDir'       => __DIR__ . '/../../app/views/',
        'pluginsDir'     => __DIR__ . '/../../app/plugins/',
        'libraryDir'     => __DIR__ . '/../../app/library/',
        'cacheDir'       => __DIR__ . '/../../app/cache/',
        'baseUri'        => '/booklist/',
    )
));
