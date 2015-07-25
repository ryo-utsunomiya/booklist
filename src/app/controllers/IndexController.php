<?php

namespace Booklist\Controller;

use Booklist\Model\Books;

class IndexController extends ControllerBase
{
    public function indexAction()
    {
        $query = Books::query()->orderBy('rate DESC, modified DESC');

        if ($search = $this->request->get('search')) {
            $query->where("title LIKE :title:", ['title' => '%' . $search . '%']);
        }

        $this->view->setVar('books', $query->execute());
    }
}

