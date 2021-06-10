<?php

namespace Tests\TinnyApi\DBConnection;

use Illuminate\Database\DatabaseManager;
use Illuminate\Database\MySqlConnection;
use PHPUnit\Framework\TestCase;
use TinnyApi\DBConnection\MySQLConnectionFactory;

class MySQLConnectionFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function createTest()
    {
        $dbManager = $this->createMock(DatabaseManager::class);
        $connection = $this->createMock(MySqlConnection::class);
        $dbManager->method('connection')->with('mysql')->willReturn($connection);
        $connectionFactory = new MySQLConnectionFactory($dbManager);

        $this->assertInstanceOf(MySqlConnection::class, $connectionFactory->create());
    }
}
