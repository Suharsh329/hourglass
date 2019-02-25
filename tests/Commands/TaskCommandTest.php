<?php /** @noinspection PhpUndefinedMethodInspection */

namespace Test\Commands;

use App\Commands\TaskCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use PHPUnit\Framework\TestCase;

class TaskCommandTest extends TestCase
{
    private $commandTester;

    private $command;

    protected function setUp(): void
    {
        $application = new Application();
        $application->add(new TaskCommand(new \App\Helpers\TaskNote(new \Test\MockDatabase())));
        $this->command = $application->find('task');
        $this->commandTester = new CommandTester($this->command);
    }

    protected function tearDown():void
    {
        $this->command = null;
        $this->commandTester = null;
    }

    public function testCannotBeATask1(): void
    {
       $this->commandTester->execute([
           'command' => $this->command->getName(),
           'task_description' => ["A", "new", "task"],
           '--due' => 's',
        ]);

        $this->assertStringContainsString('Please enter a valid number', $this->commandTester->getDisplay());
    }

    public function testCannotBeATask2(): void
    {
        $this->commandTester->execute([
            'command' => $this->command->getName(),
            'task_description' => ["A", "new", "task"],
            '--board' => ["k", "f+"], // ["_", "-"]
        ]);

        $this->assertStringContainsString('Please enter a valid board name', $this->commandTester->getDisplay());
    }


    public function testCanBeATask(): void
    {
        $this->commandTester->execute([
            'command' => $this->command->getName(),
            'task_description' => ["A", "new", "task"],
            '--board' => ["_example-"],
        ]);

        $this->assertStringContainsString('Task created', $this->commandTester->getDisplay());
    }
}