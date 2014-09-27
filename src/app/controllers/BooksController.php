<?php

namespace Booklist\Controller;

class BooksController extends ControllerBase
{
    public function addAction()
    {
        if ($this->request->isPost()) {
            $book = new \Booklist\Model\Books();
            $book->setTitle($this->request->get('title'));
            $book->setOwn(0);
            $book->setRate(0);
            if (!$book->create()) {
                foreach ($book->getMessages() as $message) {
                    echo $message->getMessage(), PHP_EOL;
                }
                exit(255);
            }
        }
    }

}

