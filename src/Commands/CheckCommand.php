<?php

namespace App\Commands;

use App\Helpers\Check;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CheckCommand extends Command
{
    protected static $defaultName = 'check';

    private $check;

    public function __construct(Check $check)
    {
        $this->check = $check;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Checks or un-checks a task from specified board.')
            ->addArgument('task', InputArgument::REQUIRED | InputArgument::IS_ARRAY, 'Tasks to check or un-check.')
            ->addOption(
                'board',
                'b',
                InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY,
                'Specify which board the task belongs to.'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $values = explode(',', implode(',', $input->getArgument('task')));

        // Default board is Main
        $boards = ['Main'];

        if ($input->getOption('board')) {
            $boards = $this->check->getValidatedBoards($input->getOption('board'));
            if(empty($boards)) {
                $output->writeln("<comment>Please enter a valid board name</comment>");
                return;
            }
        }

        $result = $this->check->task($values, $boards);

        if ($result) {
            $output->writeln("<info>Updated task(s)</info>");
            return;
        }
        $output->writeln("<comment>Could not update the specified task(s)</comment>");
    }
}