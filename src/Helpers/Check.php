<?php

namespace App\Helpers;


class Check extends Helper
{
    /**
     * Sets completed column as 1 or 0 for each task in specified board(s).
     * @param array
     * @param array
     * @return bool
     */
    public function task(array $values, array $boards, $pomodoro = false): bool
    {   
        if (!$pomodoro) {
            $sql = "UPDATE tasks_notes SET completed = (1 - completed) WHERE id = :value AND board = :board;";
        } else {
            $sql = "UPDATE tasks_notes SET completed = 1 WHERE id = :value AND board = :board;";
        }

        $stmt = $this->db->prepare($sql);

        foreach ($boards as $board) {
            foreach ($values as $value) {
                $stmt->bindParam(':value', $value);
                $stmt->bindParam(':board', $board);

                if (!$stmt->execute()) {
                    return false;
                }
            }
        }
        return true;
    }
}