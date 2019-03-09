<?php

namespace App\Commands;


use App\Helpers\Delete;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DeleteCommand extends Command
{
    protected static $defaultName = 'delete';

    private $delete;

    public function __construct(Delete $delete)
    {
        $this->delete = $delete;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Deletes tasks, notes and boards')
            ->addArgument('task_note', InputArgument::OPTIONAL | InputArgument::IS_ARRAY, 'Tasks or notes to delete.')
            ->addOption(
                'board',
                'b',
                InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY,
                'Specify which board the task belongs to.'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $values = [];

        if ($input->getArgument('task_note')) {
            $values = explode(',', implode(',', $input->getArgument('task_note')));
        }

        $flag=  false;

        // Default board is Main
        $boards = ['Main'];

        // If user enters board names with the board flag
        if ($input->getOption('board')) {
            $boards = $this->delete->getValidatedBoards($input->getOption('board'));
            if(empty($boards)) {
                $output->writeln("<comment>Please enter a valid board name</comment>");
                return;
            }
            $flag = true;
        }

        if (empty($values) && $flag === false) { // For the command hl d
            $result = $this->delete->all();
        } else if (empty($values) && $flag === true) { // For the command hl d -b board1,board2,etc...
            $result = $this->delete->boards($boards);
        } else { // For the command hl d 1 -b board1
            $result = $this->delete->taskNote($values, $boards);
        }

        if ($result) {
            $output->writeln("<info>Tasks / Notes deleted</info>");
            return;
        }
        $output->writeln("<comment>Could not delete tasks or notes</comment>");
    }
}