<?php

namespace TinnyApi\DBConnection;

use Illuminate\Database\Connection;
use Illuminate\Database\DatabaseManager;

abstract class AbstractConnectionFactory
{
    /**
     * @var DatabaseManager
     */
    protected $dbManager;

    public function __construct(DatabaseManager $dbManager)
    {
        $this->dbManager = $dbManager;
    }

    abstract protected function create(): Connection;
}
