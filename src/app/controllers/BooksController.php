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
            $this->response->redirect(base_uri());
        }
    }

    public function rateAction()
    {
        $id  = $this->dispatcher->getParam('id');
        $key = $this->dispatcher->getParam('key');

        $book = Books::findFirst($id);
        $book->updateRate($key);

        $this->response->redirect(base_uri());
    }

    public function detailAction()
    {
        $id = $this->dispatcher->getParam('id');

        $book = Books::findFirst($id);

        $this->view->setVar('book', $book);
    }

    public function deleteAction()
    {
        $id = $this->dispatcher->getParam('id');

        $book = Books::findFirst($id);

        $result = $book->delete();
        if ($result === false) {
            foreach ($book->getMessages() as $message) {
                throw new \Exception($message->getMessage(), $message->getField());
            }
        }
        $this->response->redirect(base_uri());
    }

}

