<?php

namespace App\Commands;


use App\Helpers\Update;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class MoveCommand extends Command
{

    protected static $defaultName = 'move';
    private $update;

    public function __construct(Update $update)
    {
        $this->update = $update;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Moves entries from one board to another')
            ->addArgument('id', InputArgument::REQUIRED | InputArgument::IS_ARRAY, 'Task or note id')
            ->addOption(
                'board',
                'b',
                InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
                'Specify which board the task belongs to. A new board will be created if it does not exist.'
            )
            ->addOption(
                'copy',
                'c',
                InputOption::VALUE_NONE,
                'Copy entry from one board to another.'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $id = explode(',', implode(',', $input->getArgument('id')));

        $boards = $this->update->getValidatedBoards($input->getOption('board'));

        if(empty($boards)) {
            $output->writeln("<comment>Please enter a valid board name</comment>");
            return;
        }

        if (count($boards) !== 2) {
            $output->writeln("<comment>Please enter 2 boards</comment>");
            return;
        }

        if ($input->getOption('copy')) {
            if ($this->update->copy($id, $boards[0], $boards[1])) {
                $output->writeln("<info>Entries copied</info>");
            } else {
                $output->writeln("<comment>Entries could not be moved</comment>");
            }
        } else {
            if ($this->update->move($id, $boards[0], $boards[1])) {
                $output->writeln("<info>Entries moved</info>");
            } else {
                $output->writeln("<comment>Entries could not be moved</comment>");
            }
        }
    }
}