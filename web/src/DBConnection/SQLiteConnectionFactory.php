<?php

namespace TinnyApi\DBConnection;

use Illuminate\Database\Connection;
use TinnyApi\Contracts\DatabaseConnectionFactory;

class SQLiteConnectionFactory extends AbstractConnectionFactory implements DatabaseConnectionFactory
{
    /**
     * @return Connection
     */
    public function create(): Connection
    {
        return $this->dbManager->connection('sqlite');
    }
}
