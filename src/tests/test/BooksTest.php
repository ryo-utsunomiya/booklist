<?php

namespace Test;

use Booklist\Model\Books;

class BooksTest extends \UnitTestCase
{
    public function setUp(\Phalcon\DiInterface $di = null, \Phalcon\Config $config = null)
    {
        parent::setUp($di, $config);
        $this->getDI()->get('db')->begin();
    }

    public function tearDown()
    {
        $this->getDI()->get('db')->rollback();
    }

    /**
     * @test
     */
    public function createNewBooksはBooksオブジェクトを初期化して保存する()
    {
        $book = Books::createNewBook(['title' => 'test']);
        $this->assertEquals('test', $book->getTitle());
        $this->assertEquals(0, $book->getRate());
        $this->assertEquals(0, $book->getOwn());
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function createNewBooksにtitleを渡さないと例外を投げる()
    {
        Books::createNewBook([]); // expects ['title' => 'foo']
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function duplicate_titleには例外を投げる()
    {
        $book1 = Books::createNewBook(['title' => 'test']);
        $book2 = Books::createNewBook(['title' => 'test']);
    }


    /**
     * @test
     */
    public function updateRateは与えられた値に応じてrateを上下させる()
    {
        $book = Books::createNewBook(['title' => 'test']);
        $book->updateRate(Books::RATE_PLUS);
        $this->assertEquals(1, $book->getRate());
        $book->updateRate(Books::RATE_MINUS);
        $this->assertEquals(0, $book->getRate());
    }

    /**
     * @test
     */
    public function updateRateではrateは0より小さくならない()
    {
        $book = Books::createNewBook(['title' => 'test']);
        $book->updateRate(Books::RATE_MINUS);
        $this->assertEquals(0, $book->getRate());
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function updateRateに不正な値を与えると例外を投げる()
    {
        Books::createNewBook(['title' => 'test'])->updateRate('INVALID_STRING');
    }
}
 