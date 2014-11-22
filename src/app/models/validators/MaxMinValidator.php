<?php

namespace Booklist\Model\Validator;

use Phalcon\Mvc\Model\Validator;

/**
 * Class MaxMinValidator
 * @package Booklist\Model\Validator
 *
 * 渡された値が最小値・最大値の範囲内かチェックする
 */
class MaxMinValidator extends Validator
{
    public function validate($record)
    {
        $options = $this->getOptions();

        $field = $options['field'];
        $value = $record->$field;

        if (!is_numeric($value)) {
            throw new \InvalidArgumentException('%s must be numeric value', $field);
        }

        if (isset($options['min']) && $value < $options['min']) {
            return false;
        }
        if (isset($options['max']) && $options['max'] < $value) {
            return false;
        }

        return true;
    }
}
 