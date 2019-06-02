<?php

namespace App\Commands;


use App\Helpers\Update;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateCommand extends Command
{

    protected static $defaultName = 'update';
    private $update;

    public function __construct(Update $update)
    {
        $this->update = $update;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Updates an entry')
            ->addArgument('id', InputArgument::REQUIRED, 'Task or note id')
            ->addArgument('text', InputArgument::OPTIONAL | InputArgument::IS_ARRAY, 'Task or note description')
            ->addOption(
                'change',
                'c',
                InputOption::VALUE_NONE,
                'Change task to note or vice-versa.'
            )
            ->addOption(
                'due',
                'd',
                InputOption::VALUE_OPTIONAL,
                'Specify the due date.'
            )
            ->addOption(
                'board',
                'b',
                InputOption::VALUE_OPTIONAL,
                'Specify which board the task belongs to. A new board will be created if it does not exist.'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $id = $input->getArgument('id');

        // Default board is Main
        $board = 'Main';

        if ($input->getOption('board')) {
            $board = $input->getOption('board');
        }

        // Renaming a board
        if (!ctype_digit($id)) {
            if ($board === 'Main') {
                $output->writeln("<comment>Cannot rename board: Main</comment>");
                return;
            }
            if ($this->update->board($id, $board)) {
                $output->writeln("<info>Board name updated</info>");
            } else {
                $output->writeln("<comment>Board name could not be updated</comment>");
            }
            return;
        }

        // Update task description
        if ($input->getArgument('text')) {
            $text = implode(' ', $input->getArgument('text'));

            if ($this->update->description($id, $text, $board)) {
                $output->writeln("<info>Description updated</info>");
            } else {
                $output->writeln("<comment>Description could not be updated</comment>");
            }
        }

        // Change task to note and vice-versa
        if ($input->getOption('change')) {
            if ($this->update->change($id, $board)) {
                $output->writeln("<info>Type updated</info>");
            } else {
                $output->writeln("<comment>Type could not be updated</comment>");
            }
        }

        // Update due date
        if ($input->getOption('due')) {
            if (!$this->update->isValidNumber($input->getOption('due'))) {
                $output->writeln("<comment>Please enter a valid number</comment>");
                return;
            }

            if ($input->getOption('due') === '000') {
                $due = "Indefinite";
            } else {
                // Convert the input number to actual date
                $due = $this->update->getDueDate(date('jS F Y'), $input->getOption('due'));
            }

            if ($this->update->dueDate($id, $due, $board)) {
                $output->writeln("<info>Due date updated</info>");
            } else {
                $output->writeln("<comment>Due date could not be updated</comment>");
            }
        }
    }
}