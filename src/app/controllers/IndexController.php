<?php

namespace Booklist\Controller;

use Booklist\Model\Books;

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        $books = Books::query()
                      ->orderBy('rate DESC, id ASC')
                      ->execute();

        $this->view->setVar('books', $books);
    }

}

