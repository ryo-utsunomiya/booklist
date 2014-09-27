<?php

$router = new \Phalcon\Mvc\Router(false); // デフォルトルート無効化
$router->removeExtraSlashes(true); // 末尾のスラッシュを無視

$router->add('/', 'Index::index');
$router->add('/books/new', 'Books::new');
//$router->add('/books/:id/rate/:rate', 'Books::rate');

$router->add('/books/{id}/rate/{key}', [
    'controller' => 'books',
    'action'    => 'rate',
]);

return $router;