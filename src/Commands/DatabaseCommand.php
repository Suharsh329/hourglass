<?php

namespace App\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class DatabaseCommand extends Command
{
    protected static $defaultName = 'generate';

    protected function configure()
    {
        $this->setDescription('Generates a database at given location')
            ->addArgument('path', InputArgument::OPTIONAL, 'Path of database');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Default path
        $path = getenv("HOME") . "/.hourglass/";

        if ($input->getArgument('path')) {
            $path = $input->getArgument('path');
        }

        $process = new Process(['cp', __DIR__ . '/../../hourglass_example.db', $path]);

        try {
            $process->mustRun();
            $output->writeln("<info>Database generated at: </info>" . $path);
        } catch (ProcessFailedException $exception) {
            $output->writeln("<comment>Database could not be generated.</comment>");
        }
    }
}
