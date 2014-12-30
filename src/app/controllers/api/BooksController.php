<?php

namespace Booklist\Controller\Api;

use Booklist\Model\Books;

class BooksController extends ControllerBase
{
    public function indexAction()
    {
        $books = Books::query()
                      ->orderBy('rate DESC, modified DESC')
                      ->execute();

        $content = [];

        /** @var Books $book */
        foreach ($books as $book) {
            $content[] = $book->toArray();
        }

        return $this->response->setJsonContent($content);
    }
}

