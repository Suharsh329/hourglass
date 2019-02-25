<?php

namespace Test\Mocks;


use App\Helpers\Database;

class MockDatabase extends Database
{
    private $dsn = 'sqlite:' . __DIR__ . '/../../test.db';

    public function __construct()
    {
        parent::__construct($this->dsn);
    }
}