<?php

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        $books = Books::query()
                      ->orderBy('rate DESC')
                      ->execute();

        $this->view->setVar('books', $books);
    }

    public function addAction()
    {
        
    }

}

