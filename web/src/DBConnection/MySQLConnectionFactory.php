<?php

namespace TinnyApi\DBConnection;

use Illuminate\Database\Connection;
use TinnyApi\Contracts\DatabaseConnectionFactory;

class MySQLConnectionFactory extends AbstractConnectionFactory implements DatabaseConnectionFactory
{
    /**
     * @return Connection
     */
    public function create(): Connection
    {
        return $this->dbManager->connection('mysql');
    }
}
