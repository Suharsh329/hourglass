<?php

namespace App\Helpers;


class Database extends \PDO
{
    private $dsn = 'sqlite:' . __DIR__ . '/../../hourglass.db';

    /**
     * Initializes the PDO object
     */
    public function __construct()
    {
        $options = [
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        parent::__construct($this->dsn, '', '', $options);
    }
}