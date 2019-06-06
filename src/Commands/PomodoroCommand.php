<?php

namespace App\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;

class PomodoroCommand extends Command
{
    protected static $defaultName = 'omodoro';

    protected function configure()
    {
        $this->setDescription('Starts a pomodoro timer');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $activityTime = 25 * 60 * 10;
        $progressBar = new ProgressBar($output, $activityTime);
        $progressBar->setFormat(
            "<fg=cyan;bg=default>Activity - %status:-45s%</>\n %bar%\n%elapsed%\n"
        );
        $progressBar->setBarCharacter('<fg=green>⚬</>');
        $progressBar->setEmptyBarCharacter("<fg=red>⚬</>");
        $progressBar->setProgressCharacter("<fg=green>➤</>");
        $progressBar->setBarWidth(25);

        $progressBar->setRedrawFrequency(1);
        $progressBar->start();
        for ($i = 0; $i < $activityTime; $i++) {
            if ($i <= $activityTime / 2) {
                $progressBar->setMessage("Started", 'status');
            } elseif ($i > $activityTime / 2 && $i <= 3 * $activityTime / 4) {
                $progressBar->setMessage("Halfway there", 'status');
            } else {
                $progressBar->setMessage("Almost there", 'status');
            }
            $progressBar->advance();
            usleep(100000);
        }
        $progressBar->setMessage("Completed", 'status');
        $progressBar->finish();
        $output->writeln("");
    }
}