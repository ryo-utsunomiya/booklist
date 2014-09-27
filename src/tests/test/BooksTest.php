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
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function createNewBooksにtitleを渡さないと例外を投げる()
    {
        Books::createNewBook([]); // expects ['title' => 'foo']
    }
}
 