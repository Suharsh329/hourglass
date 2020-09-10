<?php

namespace App\Helpers;


class Delete extends Helper
{

    /** Deletes all entries
     * @return bool
     */
    public function all(): bool
    {
        $archive = false;

        if (file_exists(getenv("HOME") . "/.hourglass/settings.json")) {
            $json = json_decode(file_get_contents(getenv("HOME") . "/.hourglass/settings.json"), true);
            print_r($json);
            $archive = $json['archive'];
        }

        if ($archive) {
            $sql = "SELECT * FROM task_notes;";
            $array_of_all_entries = $sql->query;

            $sql = "INSERT INTO archives(description, date, type, board) VALUES(:description, :date, :type, :board);";

            foreach ($array_of_all_entries as $entry) {
                $stmt = $this->db->prepare($sql);

                $stmt->bindParam(':description', $entry['description']);
                $stmt->bindParam(':date', $entry['date']);
                $stmt->bindParam(':type', $entry['type']);
                $stmt->bindParam(':board', $entry['board']);

                if(!$stmt->execute()) {
                    return false;
                }
            }
        }

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
        $sql = "DELETE FROM boards WHERE name = :board;";

        $stmt = $this->db->prepare($sql);

        foreach ($boards as $board) {
            $this->db->exec('PRAGMA foreign_keys = ON;');

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
        $sql = "DELETE FROM tasks_notes WHERE id = :id AND board = :board;";

        $stmt = $this->db->prepare($sql);

        foreach ($boards as $board) {
            foreach ($values as $value) {
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