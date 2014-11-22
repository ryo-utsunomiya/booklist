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
    public function findFirstはBooksオブジェクトを返す()
    {
        $book = Books::createNewBook(['title' => 'test']);

        $this->assertTrue(Books::findFirst($book->getId()) instanceof Books);
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
     * @expectedException \Exception
     */
    public function titleが重複するとには例外を投げる()
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

    /**
     * @test
     */
    public function isModifiedTodayは1日以内に更新された場合はtrueを返す()
    {
        $this->assertTrue(Books::createNewBook(['title' => 'test'])->isModifiedToday());
    }

    /**
     * @test
     */
    public function isModifiedTodayは更新から1日以上経った場合はfalseを返す()
    {
        $book = Books::createNewBook(['title' => 'test'])->setModified(date('Y-m-d H:i:s', strtotime('- 1 day')));
        $this->assertFalse($book->isModifiedToday());
    }

    /**
     * @test
     */
    public function isOldは更新から6ヶ月以上経っている場合はtrueを返す()
    {
        $old_book = Books::createNewBook(['title' => 'test'])->setModified(date('Y-m-d H:i:s', strtotime('- 7 month')));
        $this->assertTrue($old_book->isOld());
    }

    /**
     * @test
     */
    public function isOldは更新から6ヶ月以上経っていない場合はfalseを返す()
    {
        $new_book = Books::createNewBook(['title' => 'test'])->setModified(date('Y-m-d H:i:s'));
        $this->assertFalse($new_book->isOld());
    }

    /**
     * @test
     */
    public function rateIsZeroはrateが0の場合trueを返す()
    {
        $new_book = Books::createNewBook(['title' => 'test']);
        $this->assertTrue($new_book->rateIsZero());
    }

}
 