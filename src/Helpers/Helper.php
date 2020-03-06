<?php

namespace App\Helpers;


class Helper
{
    protected $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    /**
     * Returns the number of days till task is due
     * @param string $due
     * @return string
     */
    public function getRemainingDays(string $due): string
    {
        $interval = date_diff(
            date_create(date('Y-m-d')), // Today's date
            date_create(date('Y-m-d', strtotime($due))), // Due date
            false); // Absolute value
        return $interval->format('%R%a');
    }

    /**
     * Updates id of tasks and notes after deleting or updating entries
     * @return void
     */
    public function updateId(): void
    {
        $sql1 = "SELECT name FROM boards;";

        $row = $this->db->query($sql1);

        $sql2 = "SELECT id FROM tasks_notes WHERE board = :board ORDER BY id;";

        $stmt1 = $this->db->prepare($sql2);

        $sql3 = "UPDATE tasks_notes SET id = :id WHERE id = :val AND board = :board;";

        $stmt2 = $this->db->prepare($sql3);

        foreach($row as $board) {
            $stmt1->bindParam(':board', $board['name']);

            $stmt1->execute();

            $row = $stmt1->fetchAll();

            $i = 1;

            foreach ($row as $id) {
                $stmt2->bindParam(':id', $i);

                $stmt2->bindParam(':val', $id['id']);

                $stmt2->bindParam(':board', $board['name']);

                $stmt2->execute();

				$i++;
            }
        }
    }

    /**
     * Generates an id for a task or note based on board and largest id value present
     * @param string $board
     * @return int
     */
    public function generateId(string $board): int
    {
        $sql = "SELECT MAX(id) FROM tasks_notes WHERE board = :board;";

        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':board', $board);

        $stmt->execute();

        $row = $stmt->fetch();
        if ($row === NULL) {
            return 1;
        }

        return $row['MAX(id)'] + 1;
    }

    /**
     * Checks if user specified board exists or not
     * @param string $board
     * @return bool
     */
    public function boardExists(string $board): bool
    {
        $sql = "SELECT name FROM boards WHERE name = :board;";

        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':board', $board);

        $stmt->execute();

        return is_array($stmt->fetch());
    }

    /**
     * Creates a board
     * @param string $board
     * @return void
     */
    public function createBoard(string $board): void
    {
        $sql = "INSERT INTO boards(name) VALUES(:board);";

        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':board', $board);

        $stmt->execute();
    }

    /**
     * Returns due date
     * @param string $date
     * @param string $due
     * @return string
     */
    public function getDueDate(string $date, string $due): string
    {
        return date('jS F Y', strtotime($date . " + $due days"));
    }

    /**
     * Checks if the due date parameter is a number
     * @param string $value
     * @return bool
     */
    public function isValidNumber(string $value): bool
    {
        return ctype_digit($value);
    }

    /**
     * Checks if the specified board name is valid or not
     * @param string $board
     * @return bool
     */
    public function isValidBoardName(string $board): bool
    {
        // Alphanumeric names with hyphens and underscores are allowed
        $aValid = ['-', '_'];
        return ctype_alnum(str_replace($aValid, '', $board));
    }

    /**
     * All board names other than 'Main' are converted to lowercase and duplicates are removed
     * @param array $boards
     * @return array
     */
    public function sanitizeBoards(array $boards): array
    {
        $temp = [];

        foreach ($boards as $board) {
            $val = strtolower($board);
            if (strpos($val, "main") !== false) {
                $val = "Main";
            }
            array_push($temp, $val);
        }

        return array_unique($temp);
    }

    /**
     * Check if board names are valid and sanitize the boards
     * @param array $boards
     * @return array
     */
    public function getValidatedBoards(array $boards): array
    {
        $_boards = explode(',', implode(',', $boards));

        foreach ($_boards as $board) {
            if (!$this->isValidBoardName($board)) {
                return [];
            }
        }

        return $this->sanitizeBoards($_boards);
    }
}