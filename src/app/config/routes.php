<?php

$router = new \Phalcon\Mvc\Router(true); // デフォルトルート有効化
$router->removeExtraSlashes(true); // 末尾のスラッシュを無視

$router->add('/', 'Index::index');
$router->add('/books/add', 'Books::add');

return $router;