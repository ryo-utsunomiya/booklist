<?php

namespace Booklist\Model;

class Books extends Base\Books
{
    /**
     * @param array $params
     *
     * @return Books
     */
    public static function createNewBook(array $params)
    {
        if (!isset($params['title'])) {
            throw new \InvalidArgumentException('title is required');
        }

        $title = $params['title'];
        $rate  = isset($params['rate']) ? $params['rate'] : 0;
        $own   = isset($params['own']) ? $params['own'] : 0;

        $book = new self();
        $book->setTitle($title);
        $book->setRate($rate);
        $book->setOwn($own);

        if (!$book->create()) {
            foreach ($book->getMessages() as $message) {
                // todo 例外を投げてコントローラーでエラーハンドリング
                echo $message->getMessage(), PHP_EOL;
                exit(255);
            }
        }

        return $book;
    }
}
 