<?php

namespace App\Helpers;


class Database extends \PDO
{
    /**
     * Creates PDO instance
     * @param string $dsn
     */
    public function __construct($dsn = "")
    {
        if ($dsn === "") {
            if (file_exists(getenv("HOME") . "/.hourglass/settings.json")) {
                $json = json_decode(file_get_contents(getenv("HOME") . "/.hourglass/settings.json"), true);

                $path = str_replace("~", getenv("HOME"), $json['dbDirectory']);
            } else {
                $path = getenv("HOME") . "/.hourglass/";
            }

            $dsn = "sqlite:" . $path . "hourglass.db";
        }

        $options = [
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        parent::__construct($dsn, '', '', $options);
    }
}
