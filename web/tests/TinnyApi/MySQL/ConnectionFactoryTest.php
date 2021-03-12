<?php

namespace Tests\TinnyApi\MySQL;

use Illuminate\Database\DatabaseManager;
use Illuminate\Database\MySqlConnection;
use PHPUnit\Framework\TestCase;
use TinnyApi\MySQL\ConnectionFactory;

class ConnectionFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function createTest()
    {
        $dbManager = $this->createMock(DatabaseManager::class);
        $connection = $this->createMock(MySqlConnection::class);
        $dbManager->method('connection')->with('mysql')->willReturn($connection);
        $connectionFactory = new ConnectionFactory($dbManager);

        $this->assertInstanceOf(MySqlConnection::class, $connectionFactory->create());
    }
}
