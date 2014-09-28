<?php

namespace Test;

use Booklist\Model\Books;

/**
 * Class AbstractModelTest
 *
 * AbstractModelは抽象クラスなので、テストではAbstractModelを継承したBooksモデルを使用している
 *
 * @package Test
 */
class AbstractModelTest extends \UnitTestCase
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
    public function getは指定したカラムの値を返す()
    {
        $book = Books::createNewBook(['title' => 'test']);
        $this->assertEquals('test', $book->get('title'));
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function getに存在しないカラム名を渡すと例外を投げる()
    {
        Books::createNewBook(['title' => 'test'])->get('INVALID_COLUMN_NAME');
    }

}
 