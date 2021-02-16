<?php

namespace TinnyApi\SQLite;

use Illuminate\Database\DatabaseManager;
use Illuminate\Database\SQLiteConnection;
use TinnyApi\Contracts\DatabaseConnectionFactory;

class ConnectionFactory implements DatabaseConnectionFactory
{
    /**
     * @var DatabaseManager
     */
    private $dbManager;

    public function __construct(DatabaseManager $dbManager)
    {
        $this->dbManager = $dbManager;
    }

    /**
     * @return SQLiteConnection
     */
    public function create(): SQLiteConnection
    {
        return $this->dbManager->connection('sqlite');
    }
}
