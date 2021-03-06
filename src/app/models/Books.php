<?php

namespace Booklist\Model;

use Booklist\Model\Validator\MaxMinValidator;
use Phalcon\Mvc\Model\Behavior\Timestampable;
use Phalcon\Mvc\Model\Validator\PresenceOf;
use Phalcon\Mvc\Model\Validator\Uniqueness;

/**
 * Class Books
 * @package Booklist\Model
 */
class Books extends Base\Books
{
    const RATE_PLUS  = 'plus';
    const RATE_MINUS = 'minus';

    public function initialize()
    {
        $this->addBehavior(
            new Timestampable(
                [
                    'beforeCreate' => [
                        'field'  => 'created',
                        'format' => 'Y-m-d H:i:s',
                    ]
                ]
            )
        );
        $this->addBehavior(
            new Timestampable(
                [
                    'beforeSave' => [
                        'field'  => 'modified',
                        'format' => 'Y-m-d H:i:s',
                    ]
                ]
            )
        );
    }

    /**
     * @param array $parameters
     *
     * @return Books
     */
    public static function findFirst($parameters = array())
    {
        return parent::findFirst($parameters);
    }

    /**
     * @param array $params
     *
     * @return Books
     * @throws \Exception
     */
    public static function createNewBook(array $params)
    {
        if (!isset($params['title'])) {
            throw new \InvalidArgumentException('title is required');
        }

        $title = $params['title'];
        $rate  = isset($params['rate']) ? $params['rate'] : 0;
        $own   = isset($params['own']) ? $params['own'] : 0;

        $book = (new self())->setTitle($title)
                            ->setRate($rate)
                            ->setOwn($own);

        $result = $book->create();
        if ($result === false) {
            foreach ($book->getMessages() as $message) {
                throw new \Exception($message->getMessage());
            }
        }

        return $book;
    }

    /**
     * @return bool
     */
    public function validation()
    {
        $this->validate(
            new PresenceOf(
                [
                    'field'   => 'title',
                    'message' => 'タイトルが必要です',
                ]
            )
        );
        $this->validate(
            new Uniqueness(
                [
                    'field'   => 'title',
                    'message' => '同じ本を登録しています',
                ]
            )
        );
        $this->validate(
            new MaxMinValidator([
                'field'   => 'rate',
                'message' => 'rateの値が不正です',
                'min'     => 0,
            ])
        );

        if ($this->validationHasFailed()) {
            return false;
        }
        return true;
    }

    /**
     * @param $rate_string
     *
     * @return $this
     * @throws \Exception
     */
    public function updateRate($rate_string)
    {
        $result = $this->setRate($this->convertToRate($rate_string))
                       ->update();

        if ($result === false) {
            foreach ($this->getMessages() as $message) {
                throw new \Exception($message->getMessage(), $message->getField());
            }
        }

        return $this;
    }

    /**
     * 渡された文字列を元に、rateの新しい値を返す
     *
     * @param $rate_string
     *
     * @return int
     */
    private function convertToRate($rate_string)
    {
        $rate = $this->getRate();
        if ($rate_string === self::RATE_PLUS) {
            $rate++;
        } elseif ($rate_string === self::RATE_MINUS) {
            $rate--;
        } else {
            throw new \InvalidArgumentException('rate has invalid value');
        }
        return $rate;
    }

    /**
     * Method to set the value of field rate
     *
     * @param integer $rate
     *
     * @return $this
     */
    public function setRate($rate)
    {
        $this->rate = max($rate, 0); // マイナスにならないようにする

        return $this;
    }

    /**
     * @return int
     */
    public function getRate()
    {
        return (int)parent::getRate();
    }

    /**
     * @return bool
     */
    public function isModifiedToday()
    {
        $format       = 'Ymd';
        $today        = date($format);
        $modified_day = date($format, strtotime($this->getModified()));

        return ($today === $modified_day);
    }

    /**
     * @return bool
     */
    public function isOld()
    {
        return (strtotime($this->getModified()) < strtotime('- 6 month'));
    }

    /**
     * @return bool
     */
    public function rateIsZero()
    {
        return ($this->getRate() === 0);
    }

    /**
     * @return bool
     */
    public function isOldAndRateIsZero()
    {
        return ($this->isOld() && $this->rateIsZero());
    }
}
