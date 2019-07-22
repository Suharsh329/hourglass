<?php

namespace App\Helpers;

use App\Helpers\Helper;

class Filter extends Helper
{
    /**
     * Returns entries in alphabetical order
     * @param string
     * @return array
     */
    public function alpha(string $board): array
    {
        $view = [];

        if ($board !== '') {
            $sql = "SELECT * FROM tasks_notes WHERE board = :board ORDER BY description;";
        } else {
            $sql = "SELECT * FROM tasks_notes ORDER BY board, description;";
        }

        $stmt = $this->db->prepare($sql);

        if ($board !== '') {
            $stmt->bindParam(':board', $board);
        }

        $stmt->execute();

        while ($row = $stmt->fetch()) {
            $interval = 'Indefinite';

            if($row['due_date'] !== 'Indefinite') {
                $interval = intval($this->getRemainingDays($row['due_date']));
            }

            $temp = [
                'id' => $row['id'],
                'description' => $row['description'],
                'due' => $interval,
                'completed' => $row['completed'],
                'type' => $row['type'],
                'board' => $row['board']
            ];
            \array_push($view, $temp);
        }

        return $view;
    }

    /**
     * Returns tasks with due-dates
     * @param string
     * @param string
     * @return array
     */
    public function dueDate(string $value, string $board): array
    {
        $view = [];

        if ($board !== '' && $value !== '') {
            $date = date('jS F Y');
            $sql = "SELECT * FROM tasks_notes WHERE due_date != 'Indefinite' AND due_date - :date <= $value AND board = :board ORDER BY id;";
        } else if ($board === '' && $value !== '') {
            $date = date('jS F Y');
            $sql = "SELECT * FROM tasks_notes WHERE due_date != 'Indefinite' AND due_date - :date <= $value ORDER BY id;";
        } else if ($board !== '' && $value === '') {
            $sql = "SELECT * FROM tasks_notes WHERE due_date != 'Indefinite' AND board = :board ORDER BY id;";
        } else {
            $sql = "SELECT * FROM tasks_notes WHERE due_date != 'Indefinite' ORDER BY id;";
        }

        $stmt = $this->db->prepare($sql);

        if ($board !== '') {
            $stmt->bindParam(':board', $board);
        }

        if ($value !== '') {
            $stmt->bindParam(':date', $date);
        }

        $stmt->execute();

        while ($row = $stmt->fetch()) {
            $temp = [
                'id' => $row['id'],
                'description' => $row['description'],
                'due' => intval($this->getRemainingDays($row['due_date'])),
                'completed' => $row['completed'],
                'type' => $row['type'],
                'board' => $row['board']
            ];
            \array_push($view, $temp);
        }

        return $view;
    }

    /**
     * Returns notes
     * @param string
     * @return array
     */
    public function notes(string $board): array
    {
        $view = [];

        if ($board !== '') {
            $sql = "SELECT * FROM tasks_notes WHERE type = 'note' AND board = :board ORDER BY id;";
        } else {
            $sql = "SELECT * FROM tasks_notes WHERE type = 'note' ORDER BY id;";
        }

        $stmt = $this->db->prepare($sql);

        if ($board !== '') {
            $stmt->bindParam(':board', $board);
        }

        $stmt->execute();

        while ($row = $stmt->fetch()) {
            $temp = [
                'id' => $row['id'],
                'description' => $row['description'],
                'due' => $row['due_date'],
                'completed' => $row['completed'],
                'type' => $row['type'],
                'board' => $row['board']
            ];
            \array_push($view, $temp);
        }

        return $view;
    }

    /**
     * Returns tasks
     * @param string
     * @param string
     * @return array
     */
    public function tasks(string $value, string $board): array
    {
        $view = [];

        if ($board !== '' && $value !== '') {
            $complete = $value === 'i' ? 0 : 1;
            $sql = "SELECT * FROM tasks_notes WHERE type = 'task' AND completed = :complete AND board = :board ORDER BY id;";
        } else if ($board === ''&& $value !== '') {
            $complete = $value === 'i' ? 0 : 1;
            $sql = "SELECT * FROM tasks_notes WHERE type = 'task' AND completed = :complete ORDER BY id;";
        } else if ($board !== ''&& $value === '') {
            $sql = "SELECT * FROM tasks_notes WHERE type = 'task' AND board = :board ORDER BY id;";
        } else {
            $sql = "SELECT * FROM tasks_notes WHERE type = 'task' ORDER BY id;";
        }

        $stmt = $this->db->prepare($sql);

        if ($board !== '') {
            $stmt->bindParam(':board', $board);
        }

        if ($value !== '') {
            $stmt->bindParam(':complete', $complete);
        }

        $stmt->execute();

        while ($row = $stmt->fetch()) {
            $interval = 'Indefinite';

            if($row['due_date'] !== 'Indefinite') {
                $interval = intval($this->getRemainingDays($row['due_date']));
            }

            $temp = [
                'id' => $row['id'],
                'description' => $row['description'],
                'due' => $interval,
                'completed' => $row['completed'],
                'type' => $row['type'],
                'board' => $row['board']
            ];
            \array_push($view, $temp);
        }

        return $view;
    }
}
