<?php

namespace App\Commands;

use App\Helpers\Create;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class TaskCommand extends Command
{
    protected  static $defaultName = 'task';

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
        $task = implode(' ', $input->getArgument('task_description'));

        $boards = ['Main'];

        if ($input->getOption('board')) {
            $boards = explode(',', implode(",", $input->getOption('board')));
        }

        foreach ($boards as $board) {
            if (!$this->isValidInput($board, 'board')) {
                $output->writeln("<comment>Please enter a valid board name</comment>");
                return;
            }
        }

        $boards = $this->sanitizeBoards($boards);

        $due = 'Indefinite';

        if ($input->getOption('due')) {
            if (!$this->isValidInput($input->getOption('due'), 'due')) {
                $output->writeln("<comment>Please enter a valid number</comment>");
                return;
            }
            $due = $input->getOption('due');
        }

        $task = [
            'task' => $task,
            'boards' => $boards,
            'due' => $due,
            'date' => date('jS F Y') // 1st February 2019
        ];

        $output->writeln("<info>Task created: " . $task['task'] ." </info>");
    }

    protected function isValidInput(string $value, string $type)
    {
        // Check if board name is valid
        // Alphanumeric names with hyphens and underscores are allowed
        if ($type === 'board') {
            $aValid = ['-', '_'];
            return ctype_alnum(str_replace($aValid, '', $value));
        }

        // Check if due date is a valid number
        return ctype_digit($value);
    }

    protected function sanitizeBoards(array $boards): array
    {
        $temp = array_map(function($board) {
            $val = strtolower($board);
            if($val == "main") {
                $val = "Main";
            }
            return $val;
        }, $boards);

        return array_unique($temp);
    }
}