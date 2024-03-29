<?php

namespace App\Helpers;


use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\OutputInterface;

class Pomodoro extends Helper
{

    /**
     * @param OutputInterface $output
     * @param int $activityTime
     * @param int $time
     * @return ProgressBar
     */
    public function initProgressBar(OutputInterface $output, int $activityTime, int $count): ProgressBar
    {
        $progressBar = new ProgressBar($output, $activityTime);
        $progressBar->setFormat(
            "<fg=cyan;bg=default>%status:-45s%</>\n %bar%\n%elapsed%\n"
        );
        $progressBar->setBarCharacter("<fg=green> O</>");
        $progressBar->setEmptyBarCharacter("<fg=red> O</>");
        $progressBar->setProgressCharacter("<fg=green>➤</>");
        $progressBar->setBarWidth($count);

        $progressBar->setRedrawFrequency(1);

        return $progressBar;
    }

    /**
     * @param int $id
     * @param string $board
     * @return string
     */
    public function getTask(int $id, string $board): string
    {
        $sql = "SELECT description FROM tasks_notes WHERE id = :id AND board = :board;";

        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':board', $board);

        $stmt->execute();

        $row = $stmt->fetch();

        if ($row) {
            return $row['description'];
        }

        return "";
    }
}