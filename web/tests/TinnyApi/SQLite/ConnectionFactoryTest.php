<?php

namespace Tests\TinnyApi\SQLite;

use Illuminate\Database\DatabaseManager;
use Illuminate\Database\SQLiteConnection;
use PHPUnit\Framework\TestCase;
use TinnyApi\SQLite\ConnectionFactory;

class ConnectionFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function createTest()
    {
        $dbManager = $this->createMock(DatabaseManager::class);
        $connection = $this->createMock(SQLiteConnection::class);
        $dbManager->method('connection')->willReturn($connection);
        $connectionFactory = new ConnectionFactory($dbManager);

        $this->assertInstanceOf(SQLiteConnection::class, $connectionFactory->create());
    }
}
