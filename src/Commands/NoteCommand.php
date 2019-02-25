<?php

namespace App\Commands;

use App\Helpers\TaskNote;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class NoteCommand extends Command
{
    protected static $defaultName = 'note';

    private $note;

    public function __construct(TaskNote $note)
    {
        $this->note = $note;

        parent::__construct();
    }
    protected function configure()
    {
        $this->setDescription('Creates a new note')
            ->addArgument('note_description', InputArgument::REQUIRED | InputArgument::IS_ARRAY, 'Note description')
            ->addOption(
                'board',
                'b',
                InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY,
                'Specify which board the task belongs to. A new board will be created if it does not exist.'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $noteDescription = implode(' ', $input->getArgument('note_description'));

        // Default board is Main
        $boards = ['Main'];

        // If user enters board names with the board flag
        if ($input->getOption('board')) {
            $boards = $this->note->getValidatedBoards($input->getOption('board'));
            if(empty($boards)) {
                $output->writeln("<comment>Please enter a valid board name</comment>");
                return;
            }
        }

        $note = [
            'description' => $noteDescription,
            'boards' => $boards,
            'date' => date('jS F Y'), // Today's date e.g 4th February 2019
            'type' => 'note'
        ];

        if ($this->note->createNote($note)) {
            $output->writeln("<info>Note created</info>");
        } else {
            $output->writeln("<comment>Note could not created</comment>");
        }
    }
}