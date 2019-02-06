<?php /** @noinspection SqlNoDataSourceInspection */

namespace App\Helpers;


class TaskNote extends Helper
{
    /**
     * Adds specified task to database
     * @param array $task
     * @return bool
     */
    public function createTask(array $task): bool
    {
        foreach ($task['boards'] as $board) {
            if (!$this->boardExists($board)) {
                $this->createBoard($board);
            }

            $id = $this->generateId($board);

            $sql = "INSERT INTO tasks_notes(id, description, date, due_date, type, board) VALUES(:id, :description, :date, :due_date, :type, :board);";

            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':description', $task['description']);
            $stmt->bindParam(':date', $task['date']);
            $stmt->bindParam(':due_date', $task['due']);
            $stmt->bindParam(':type', $task['type']);
            $stmt->bindParam(':board', $board);

            if(!$stmt->execute()) {
                return false;
            }
        }
        return true;
    }

    /**
     * Adds specified note to database
     * @param array $note
     * @return bool
     */
    public function createNote(array $note): bool
    {
        foreach ($note['boards'] as $board) {
            if (!$this->boardExists($board)) {
                $this->createBoard($board);
            }

            $id = $this->generateId($board);

            $sql = "INSERT INTO tasks_notes(id, description, date, type, board) VALUES(:id, :description, :date, :type, :board);";

            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':description', $note['description']);
            $stmt->bindParam(':date', $note['date']);
            $stmt->bindParam(':type', $note['type']);
            $stmt->bindParam(':board', $board);

            if(!$stmt->execute()) {
                return false;
            }
        }
        return true;
    }
}