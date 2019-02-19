<?php

namespace App\Helpers;


class Database extends \PDO
{
    /**
     * Initializes the PDO object
     * @param string $dsn
     */
    public function __construct($dsn="sqlite:". __DIR__ . "/../../hourglass.db")
    {
        $options = [
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        parent::__construct($dsn, '', '', $options);
    }
}