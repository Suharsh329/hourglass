<?php

namespace App\Helpers;

class Display extends Helper
{
    /**
     * Checks if the database has any tasks or notes
     * @return bool
     */
    public function hasEntries(): bool
    {
        $sql = "SELECT COUNT(*) FROM tasks_notes;";

        $stmt = $this->db->query($sql);

        $row = $stmt->fetch();

        return $row['COUNT(*)'] != 0;
    }

    /**
     * Returns an array of tasks and notes retrieved from the database
     * @return array
     */
    public function getEntries(): array
    {
        $entries = [];

        $stmt = $this->db->query("SELECT * FROM tasks_notes ORDER BY board, id;");

        while ($row = $stmt->fetch()) {
            $interval = 'Indefinite';

            if ($row['due_date'] !== 'Indefinite') {
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

            \array_push($entries, $temp);
        }
        return $entries;
    }
}
