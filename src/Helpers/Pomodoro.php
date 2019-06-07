<?php

namespace App\Helpers;


use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\OutputInterface;

class Pomodoro
{

    /**
     * @param OutputInterface $output
     * @param int $activityTime
     * @param int $time
     * @return ProgressBar
     */
    public function initProgressBar(OutputInterface $output, int $activityTime, int $time): ProgressBar
    {
        $progressBar = new ProgressBar($output, $activityTime);
        $progressBar->setFormat(
            "<fg=cyan;bg=default>Activity - %status:-45s%</>\n %bar%\n%elapsed%\n"
        );
        $progressBar->setBarCharacter('<fg=green>⚬</>');
        $progressBar->setEmptyBarCharacter("<fg=red>⚬</>");
        $progressBar->setProgressCharacter("<fg=green>➤</>");
        $progressBar->setBarWidth($time);

        $progressBar->setRedrawFrequency(1);

        return $progressBar;
    }

    /**
     * @param int $id
     * @return string
     */
    public function getTask(int $id): string
    {
        return "";
    }
}