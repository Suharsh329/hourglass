<?php

namespace Test\Mocks;

use App\Helpers\Helper;

class MockHelper extends Helper
{
    public function __construct()
    {
        parent::__construct(new MockDatabase());
    }

    public function deleteAllBoards(): void
    {
        $sql = "DELETE FROM boards;";

        $stmt = $this->db->prepare($sql);

        $stmt->execute();
    }

    public function addBoard(string $board): void
    {
        $sql = "INSERT INTO boards(name) VALUES(:board);";

        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':board', $board);

        $stmt->execute();
    }

    /**
     *
     */
    public function deleteAll(): void
    {
        $sql = "DELETE FROM task_notes;";

        $stmt = $this->db->prepare($sql);

        $stmt->execute();
    }

    /**
     * @param array $task
     */
    public function addTask(array $task): void
    {
        $sql = "INSERT INTO tasks_notes(id, description, date, due_date, type, board) VALUES(:id, :description, :date, :due_date, :type, :board);";

        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':id', $task['id']);
        $stmt->bindParam(':description', $task['description']);
        $stmt->bindParam(':date', $task['date']);
        $stmt->bindParam(':due_date', $task['due']);
        $stmt->bindParam(':type', $task['type']);
        $stmt->bindParam(':board', $task['board']);

        $stmt->execute();
    }

    public function addNote(array $note): void
    {
        $sql = "INSERT INTO tasks_notes(id, description, date, due_date, type, board) VALUES(:id, :description, :date, :due_date, :type, :board);";

        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':id', $note['id']);
        $stmt->bindParam(':description', $note['description']);
        $stmt->bindParam(':date', $note['date']);
        $stmt->bindParam(':due_date', $note['due']);
        $stmt->bindParam(':type', $note['type']);
        $stmt->bindParam(':board', $note['board']);

        $stmt->execute();
    }
}