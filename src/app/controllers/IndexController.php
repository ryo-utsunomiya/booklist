<?php

namespace Booklist\Controller;

use Booklist\Model\Books;

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        $books = Books::query()
                      ->orderBy('rate DESC, modified DESC')
                      ->execute();

        $this->view->setVar('books', $books);
    }

}

