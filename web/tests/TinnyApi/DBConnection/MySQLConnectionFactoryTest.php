<?php

namespace Tests\TinnyApi\DBConnection;

use Illuminate\Database\Connection;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\MySqlConnection;
use Tests\TestCase;
use TinnyApi\DBConnection\MySQLConnectionFactory;

class MySQLConnectionFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function createTest()
    {
        $dbManager = $this->createMock(DatabaseManager::class);
        $dbManager->method('connection')->with('mysql')->willReturn($this->createMock(MySqlConnection::class));
        $factory = new MySQLConnectionFactory($dbManager);

        $this->assertInstanceOf(Connection::class, $factory->create());
    }
}
