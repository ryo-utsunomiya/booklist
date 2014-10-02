<?php

namespace Booklist\Model;

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

    // error type
    const ERROR_TITLE_PRESENCE   = 'Presence';
    const ERROR_TITLE_UNIQUENESS = 'Unique';

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

        $book = (new self())->setTitle($title)->setRate($rate)->setOwn($own);

        if (!$book->create()) {
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

        if ($this->validationHasFailed()) {
            return false;
        }
        return true;
    }

    /**
     * @param $key
     *
     * @return $this
     * @throws \Exception
     */
    public function updateRate($key)
    {
        if ($key === self::RATE_PLUS) {
            $rate = $this->getRate() + 1;
            $this->setRate($rate);
        } elseif ($key === self::RATE_MINUS) {
            $rate = max(0, $this->getRate() - 1); // マイナスにならないようにする
            $this->setRate($rate);
        } else {
            throw new \InvalidArgumentException('rate has invalid value');
        }
        if (!$this->update()) {
            foreach ($this->getMessages() as $message) {
                throw new \Exception($message->getMessage(), $message->getField());
            }
        }

        return $this;
    }
}
 