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

    public function rateAction()
    {
        //if (!$this->request->isPost()) {
        //    // todo error
        //}
        $id  = $this->dispatcher->getParam('id');
        $key = $this->dispatcher->getParam('key');

        $book = Books::findFirst($id);
        $book->updateRate($key);

        $this->dispatcher->forward(['controller' => 'index', 'action' => 'index']);
    }

}

