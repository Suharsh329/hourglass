<?php

namespace App\Helpers;


class Delete extends Helper
{

    /** Deletes all entries
     * @return bool
     */
    public function all(): bool
    {
        $sql = "DELETE FROM boards;";

        $this->db->exec('PRAGMA foreign_keys = ON;');

        if (!$this->db->exec($sql)) {
            return false;
        }

        return true;
    }

    /** Deletes specified boards
     * @param array $boards
     * @return bool
     */
    public function boards(array $boards): bool
    {
        foreach ($boards as $board) {
            $this->db->exec('PRAGMA foreign_keys = ON;');

            $sql = "DELETE FROM boards WHERE name = :board;";

            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(':board', $board);

            if(!$stmt->execute()) {
                return false;
            }
        }

        return true;
    }

    /** Deletes tasks and notes for specified boards
     * @param array $values
     * @param array $boards
     * @return bool
     */
    public function taskNote(array $values, array $boards): bool
    {
        foreach ($boards as $board) {
            foreach ($values as $value) {
                $sql = "DELETE FROM tasks_notes WHERE id = :id AND board = :board;";

                $stmt = $this->db->prepare($sql);

                $stmt->bindParam(':id', $value);
                $stmt->bindParam(':board', $board);

                if(!$stmt->execute()) {
                    return false;
                }
            }
        }

        $this->updateId();

        return true;
    }
}