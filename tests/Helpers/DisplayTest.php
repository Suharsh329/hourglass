<?php /** @noinspection PhpUndefinedMethodInspection */

namespace Test\Helpers;


use App\Helpers\Display;
use PHPUnit\Framework\TestCase;
use Test\Mocks\MockDatabase;
use Test\Mocks\MockHelper;

class DisplayTest extends TestCase
{
    protected $helper;
    protected $display;

    protected function setUp(): void
    {
        $this->helper = new MockHelper();
        $this->display = new Display(new MockDatabase());
    }

    protected function tearDown(): void
    {
        unset($this->helper);
    }

    // The following two tests depend on the date they are executed. Change the values as per the date on which you run the tests.
    /*
    public function testRemainingDays1()
    {
        $this->assertStringContainsString("+3", $this->display->getRemainingDays("15th March 2019"));
    }

    public function testRemainingDays2()
    {
        $this->assertStringContainsString("-2", $this->display->getRemainingDays("10th March 2019"));
    }*/


    public function testHasNoEntries()
    {
        $this->helper->deleteAllBoards();
        $this->helper->deleteAll();
        $this->assertFalse($this->display->hasEntries());
    }

    public function testHasEntries()
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

        $this->assertTrue($this->display->hasEntries());
    }
}