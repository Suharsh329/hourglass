<?php /** @noinspection PhpUndefinedMethodInspection */

namespace Test\Commands;

use App\Commands\NoteCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use PHPUnit\Framework\TestCase;

class NoteCommandTest extends TestCase
{
    private $commandTester;

    private $command;

    protected function setUp(): void
    {
        $application = new Application();
        $application->add(new NoteCommand(new \App\Helpers\TaskNote(new \Test\Mocks\MockDatabase())));
        $this->command = $application->find('note');
        $this->commandTester = new CommandTester($this->command);
    }

    protected function tearDown():void
    {
        $this->command = null;
        $this->commandTester = null;
    }

    public function testCannotBeANote(): void
    {
        $this->commandTester->execute([
            'command' => $this->command->getName(),
            'note_description' => ["A", "new", "note"],
            '--board' => ["k", "f+"], // ["_", "-"]
        ]);

        $this->assertStringContainsString('Please enter a valid board name', $this->commandTester->getDisplay());
    }


    public function testCanBeANote(): void
    {
        $this->commandTester->execute([
            'command' => $this->command->getName(),
            'note_description' => ["A", "new", "note"],
            '--board' => ["_example-"],
        ]);

        $this->assertStringContainsString('Note created', $this->commandTester->getDisplay());
    }
}