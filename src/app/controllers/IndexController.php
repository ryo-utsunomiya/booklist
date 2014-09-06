<?php

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        $this->view->setVar('books', Books::find());
    }

}

