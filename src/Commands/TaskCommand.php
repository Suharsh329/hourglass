<?php

namespace App\Commands;

use App\Helpers\TaskNote;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class TaskCommand extends Command
{
    protected  static $defaultName = 'task';
    protected $task;

    public function __construct(TaskNote $note)
    {
        $this->task = $note;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Create a new task')
            ->addArgument('task_description', InputArgument::REQUIRED | InputArgument::IS_ARRAY, 'Task description')
            ->addOption(
                'board',
                'b',
                InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY,
                'Specify which board the task belongs to. A new board will be created if it does not exist.'
            )
            ->addOption(
                'due',
                'd',
                InputOption::VALUE_OPTIONAL,
                'Specify the due date.'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $taskDescription = implode(' ', $input->getArgument('task_description'));

        // Default board is Main
        $boards = ['Main'];

        if ($input->getOption('board')) {
            $boards = $this->task->getValidatedBoards($input->getOption('board'));
            if(empty($boards)) {
                $output->writeln("<comment>Please enter a valid board name</comment>");
                return;
            }
        }

        // Default due date is indefinite
        $due = 'Indefinite';

        // If user enters a number with the due date flag
        if ($input->getOption('due')) {
            if (!$this->task->isValidInput($input->getOption('due'), 'due')) {
                $output->writeln("<comment>Please enter a valid number</comment>");
                return;
            }
            // Convert the due date from input number to actual date
            $due = $this->task->getDueDate(date('jS F Y'), $input->getOption('due'));
        }

        $task = [
            'description' => $taskDescription,
            'boards' => $boards,
            'due' => $due,
            'date' => date('jS F Y'), // Today's date e.g 1st February 2019
            'type' => 'task'
        ];

        if ($this->task->createTask($task)) {
            $output->writeln("<info>Task created</info>");
        } else {
            $output->writeln("<comment>Task could not created</comment>");
        }
    }
}