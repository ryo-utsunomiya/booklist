<?php

namespace Booklist\Model;

class Books extends Base\Books
{
    const RATE_PLUS  = 'plus';
    const RATE_MINUS = 'minus';

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
     */
    public static function createNewBook(array $params)
    {
        if (!isset($params['title'])) {
            throw new \InvalidArgumentException('title is required');
        }

        $title = $params['title'];
        $rate  = isset($params['rate']) ? $params['rate'] : 0;
        $own   = isset($params['own']) ? $params['own'] : 0;

        $book = new self();
        $book->setTitle($title);
        $book->setRate($rate);
        $book->setOwn($own);

        if (!$book->create()) {
            foreach ($book->getMessages() as $message) {
                // todo 例外を投げてコントローラーでエラーハンドリング
                echo $message->getMessage(), PHP_EOL;
                exit(255);
            }
        }

        return $book;
    }

    /**
     * @param string $key
     */
    public function updateRate($key)
    {
        if ($key === self::RATE_PLUS) {
            $this->setRate($this->getRate() + 1);
        } elseif ($key === self::RATE_MINUS) {
            $rate = max(0, $this->getRate() - 1); // マイナスにならないようにする
            $this->setRate($rate);
        } else {
            throw new \InvalidArgumentException('rate has invalid value');
        }
        if (!$this->update()) {
            // todo error handling
        }
    }
}
 