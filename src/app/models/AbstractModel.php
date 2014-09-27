<?php

namespace Booklist\Model;

class AbstractModel extends \Phalcon\Mvc\Model
{
    public function initialize()
    {
        $this->useDynamicUpdate(true);
    }
}
 