<?php

use App\Commands\TaskCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use PHPUnit\Framework\TestCase;

class TaskCommandTest extends TestCase
{
    private $commandTester;

    protected function setUp(): void
    {
        $application = new Application();
        $application->add(new TaskCommand());
        $command = $application->find('task');
        $this->commandTester = new CommandTester($command);
    }

    protected function tearDown():void
    {
        $this->commandTester = null;
    }

    public function testCannotBeAValidDueDate(): void
    {
       $this->commandTester->execute([
           'command' => 'task',
           'task_description' => ["A", "new", "task"],
           '--due' => 's',
        ]);

        $this->assertStringContainsString('Please enter a valid number', $this->commandTester->getDisplay());
    }

    public function testCannotBeABoardName(): void
    {
        $this->commandTester->execute([
            'command' => 'task',
            'task_description' => ["A", "new", "task"],
            '--board' => ["k", "f+"],
        ]);

        $this->assertStringContainsString('Please enter a valid board name', $this->commandTester->getDisplay());
    }

    /*public function testBoardNames(): void
    {
        $this->commandTester->execute([
            'command' => 'task',
            'task_description' => ["A", "new", "task"],
            '--board' => ["Main", "main", "MaIn", "K"],
        ]);

        $this->assertStringContainsString("Main k", $this->commandTester->getDisplay());
    }*/
}