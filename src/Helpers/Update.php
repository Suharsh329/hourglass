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
     * @param string $value
     * @param string $board
     * @return bool
     */
    public function board(string $value, string $board): bool
    {
        $sql = "UPDATE boards SET name = :value WHERE name = :board;";

        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':value', $value);
        $stmt->bindParam(':board', $board);

        $this->db->exec('PRAGMA foreign_keys = ON;');

        if (!$stmt->execute()) {
            return false;
        }

        return true;
    }

    /**
     * @param string $id
     * @param string $board
     * @return bool
     */
    public function change(string $id, string $board): bool
    {
        $sql = "UPDATE tasks_notes SET type = CASE WHEN type = 'note' THEN 'task' ELSE 'note' END, completed = 0, due_date = 'Indefinite' WHERE id = :id AND board = :board;";

        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':id', $id);
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

    /**
     * @param array $id
     * @param string $to
     * @param string $from
     * @return bool
     */
    public function move(array $id, string $to, string $from): bool
    {
        if (!$this->boardExists($to)) {
            $this->createBoard($to);
        }

        $sql = "UPDATE tasks_notes SET id = :newId, board = :to WHERE id = :id AND board = :from;";

        $stmt = $this->db->prepare($sql);

        foreach ($id as $_id) {
            $newId = $this->generateId($to); // Assures that the entry moved will always be the last entry in the new board
            $stmt->bindParam(':newId', $newId);
            $stmt->bindParam(':to', $to);
            $stmt->bindParam(':id', $_id);
            $stmt->bindParam(':from', $from);

            if (!$stmt->execute()) {
                return false;
            }
        }

        $this->updateId();

        return true;
    }
}