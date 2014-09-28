<?php

namespace Booklist\Model;

/**
 * Class AbstractModel
 *
 * The root model of all model classes in this app.
 * Implements common methods.
 *
 * @package Booklist\Model
 */
abstract class AbstractModel extends \Phalcon\Mvc\Model
{
    public function initialize()
    {
        $this->useDynamicUpdate(true);
    }

    /**
     * @param $column
     *
     * @return mixed
     */
    public function get($column)
    {
        if (!isset($this->columnMap()[$column])) {
            throw new \InvalidArgumentException(sprintf('column %s does not exit', $column));
        }
        return $this->$column;
    }

    /**
     * @return array
     */
    public function columnMap()
    {
        return [];
    }
}
 