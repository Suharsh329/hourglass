<?php /** @noinspection PhpUndefinedMethodInspection */

namespace Test\Helpers;


use PHPUnit\Framework\TestCase;
use Test\Mocks\MockHelper;

class HelperTest extends TestCase
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

    public function testIsValidNumber()
    {
        $this->assertTrue($this->helper->isValidNumber("10"));
    }

    public function testIsNotAValidNumber()
    {
        $this->assertFalse($this->helper->isValidNumber("5days"));
    }

    public function testIsAValidBoardName()
    {
        $this->assertTrue($this->helper->isValidBoardName("board"));
    }

    public function testIsNotAValidBoardName()
    {
        $this->assertFalse($this->helper->isValidBoardName("_"));
    }

    public function testDueDate()
    {
        $this->assertStringContainsString($this->helper->getDueDate("22nd February 2019", "1"), "23rd February 2019");
    }

}