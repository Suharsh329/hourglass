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
     * Generates an id for a task or note based on board and largest id value present
     * @param string $board
     * @return int
     */
    protected function generateId(string $board): int
    {
        $sql = "SELECT MAX(id) FROM tasks_notes WHERE board = :board";

        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':board', $board);

        $stmt->execute();

        $row = $stmt->fetch();
        if($row === NULL) {
            return 1;
        }

        return $row['MAX(id)'] + 1;
    }

    /**
     * Checks if user specified board exists or not
     * @param string $board
     * @return bool
     */
    protected function boardExists(string $board): bool
    {
        $sql = "SELECT name FROM boards WHERE name = :board";

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
    protected function createBoard(string $board): void
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
     * Checks if due date is a valid number and if board name is alphanumeric
     * @param string $value
     * @param string $type
     * @return bool
     */
    public function isValidInput(string $value, string $type): bool
    {
        // Check if board name is valid
        // Alphanumeric names with hyphens and underscores are allowed
        if ($type === 'board') {
            $aValid = ['-', '_'];
            return ctype_alnum(str_replace($aValid, '', $value));
        }

        // Check if due date is a number
        return ctype_digit($value);
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
            if($val == "main") {
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
        $_boards = explode(',', implode(",", $boards));

        foreach ($_boards as $board) {
            if (!$this->isValidInput($board, 'board')) {
                return [];
            }
        }

        return $this->sanitizeBoards($boards);
    }
}