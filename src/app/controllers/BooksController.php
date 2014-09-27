<?php

namespace Booklist\Controller;

use Booklist\Model\Books;

class BooksController extends ControllerBase
{
    public function newAction()
    {
        if ($this->request->isPost()) {
            Books::createNewBook(['title' => $this->request->get('title')]);
        }
    }

}

