<?php

$router = new \Phalcon\Mvc\Router(false); // デフォルトルート無効化
$router->removeExtraSlashes(true); // 末尾のスラッシュを無視

$router->add('/', 'Index::index');
$router->add('/books/new', 'Books::new');
$router->add('/books/{id}/detail', 'Books::detail');
$router->add('/books/{id}/delete', 'Books::delete');
$router->add('/books/{id}/rate/{key}', 'Books::rate');

$api = new \Phalcon\Mvc\Router\Group();
$api->setPrefix('/api');
$api->add('/books', 'Booklist\Controller\Api\Books::index');

$router->mount($api);

return $router;
