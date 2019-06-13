<?php

namespace App\Commands;

use App\Helpers\Pomodoro;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class PomodoroCommand extends Command
{
    protected static $defaultName = 'pomodoro';

    protected $pomodoro;

    public function __construct(Pomodoro $pomodoro)
    {
        $this->pomodoro = $pomodoro;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Starts a pomodoro timer')
            ->addArgument('task', InputArgument::OPTIONAL, 'Task id')
            ->addOption(
                'time',
                't',
                InputOption::VALUE_OPTIONAL,
                'Specify activity time'
            )
            ->addOption(
                'rest',
                'r',
                InputOption::VALUE_OPTIONAL,
                'Specify rest time'
            )
            ->addOption(
                'board',
                'b',
                InputOption::VALUE_OPTIONAL,
                'Specify which board the task belongs to'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $task = 'Activity';
        $board = 'Main';

        if ($input->getOption('board')) {
            $board = $input->getOption('board');
        }

        if ($input->getArgument('task')) {
            $task = $this->pomodoro->getTask($input->getArgument('task'), $board);
        }

        $aTime = 25;
        if ($input->getOption('time')) {
            $aTime = $input->getOption('time');
        }

        $rTime = 5;
        if ($input->getOption('rest')) {
            $rTime = $input->getOption('rest');
        }

        $activityTime = $aTime * 60 * 10;

        $breakTime = $rTime * 60 * 10;

        $progressBar = $this->pomodoro->initProgressBar($output, $activityTime, $aTime);

        $progressBar->start();
        for ($i = 0; $i < $activityTime; $i++) {
            if ($i <= $activityTime / 2) {
                $progressBar->setMessage($task . " - Started", 'status');
            } else if ($i > $activityTime / 2 && $i <= 3 * $activityTime / 4) {
                $progressBar->setMessage($task . " - Halfway there", 'status');
            } else {
                $progressBar->setMessage($task . " - Almost there", 'status');
            }
            $progressBar->advance();
            usleep(100000);
        }
        $progressBar->setMessage($task . " - Completed", 'status');
        $progressBar->finish();

        $output->writeln("");
    }
}