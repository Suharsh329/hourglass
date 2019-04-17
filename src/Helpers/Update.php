<?php

namespace App\Helpers;


class Update extends Helper
{
    /**
     * @param string $id
     * @param string $value
     * @param string $board
     * @return bool
     */
    public function description(string $id, string $value, string $board): bool
    {
        $sql = "UPDATE tasks_notes SET description = :value WHERE id = :id AND board = :board;";

        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':value', $value);
        $stmt->bindParam(':board', $board);

        if (!$stmt->execute()) {
            return false;
        }

        return true;
    }

    /**
     * @param string $id
     * @param string $value
     * @param string $board
     * @return bool
     */
    public function change(string $id, string $value, string $board): bool
    {
        if ($value === 'note') {
            $sql = "UPDATE tasks_notes SET type = :value, completed = 0, due_date = 'Indefinite' WHERE id = :id AND board = :board;";
        } else {
            $sql = "UPDATE tasks_notes SET type = :value WHERE id = :id AND board = :board;";
        }

        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':value', $value);
        $stmt->bindParam(':board', $board);

        if (!$stmt->execute()) {
            return false;
        }

        return true;
    }

    /**
     * @param string $id
     * @param string $value
     * @param string $board
     * @return bool
     */
    public function dueDate(string $id, string $value, string $board): bool
    {
        $sql = "UPDATE tasks_notes SET due_date = :value WHERE id = :id AND board = :board AND type = 'task';";

        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':value', $value);
        $stmt->bindParam(':board', $board);

        if (!$stmt->execute()) {
            return false;
        }

        return true;
    }
}