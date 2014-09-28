<?php

namespace Booklist\Controller;

use Booklist\Model\Books;

/**
 * Class BooksController
 * @package Booklist\Controller
 */
class BooksController extends ControllerBase
{
    public function newAction()
    {
        if ($this->request->isPost()) {
            try {
                Books::createNewBook(['title' => $this->request->get('title')]);
            } catch (\Exception $e) {
                $this->view->setVar('error', $e->getMessage());
            }
        }
    }

    public function rateAction()
    {
        $id  = $this->dispatcher->getParam('id');
        $key = $this->dispatcher->getParam('key');

        Books::findFirst($id)
             ->updateRate($key);

        $this->response->redirect('');
    }

    public function detailAction()
    {
        $id = $this->dispatcher->getParam('id');

        $book = Books::findFirst($id);

        $this->view->setVar('book', $book);
    }

}

