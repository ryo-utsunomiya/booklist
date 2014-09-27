<?php

namespace Booklist\Controller;

use Booklist\Controller;

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        $books = \Booklist\Model\Books::query()
                      ->orderBy('rate DESC')
                      ->execute();

        $this->view->setVar('books', $books);
    }

}

