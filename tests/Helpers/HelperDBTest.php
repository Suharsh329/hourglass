<?php /** @noinspection PhpUndefinedMethodInspection */

namespace Test\Helpers;


use PHPUnit\Framework\TestCase;
use Test\Mocks\MockHelper;

class HelperDBTest extends TestCase
{
    protected $helper;

    protected function setUp(): void
    {
        $this->helper = new MockHelper();
    }

    protected function tearDown(): void
    {
        unset($this->helper);
    }

    public function testBoardExists()
    {
        $this->helper->deleteAllBoards();

        $this->assertFalse($this->helper->boardExists("Main"));
    }

    public function testId1()
    {
        $this->helper->deleteAllBoards();

        $board = "Main";

        $this->helper->addBoard($board);

        $this->assertEquals(1, $this->helper->generateId($board));
    }

    public function testId2()
    {
        $this->helper->deleteAllBoards();

        $board = "Main";

        $this->helper->addBoard($board);

        $this->helper->addTask([
            "id" => 1,
            "description" => "Test task",
            "date" => "23rd February 2019",
            "due_date" => "Indefinite",
            "type" => "task",
            "board" => "Main"
        ]);

        $this->assertEquals(2, $this->helper->generateId($board));
    }
}