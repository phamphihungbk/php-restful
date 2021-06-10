<?php

namespace Tests\TinnyApi\DBConnection;

use Illuminate\Database\DatabaseManager;
use Illuminate\Database\SQLiteConnection;
use PHPUnit\Framework\TestCase;
use TinnyApi\DBConnection\SQLiteConnectionFactory;

class SQLiteConnectionFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function createTest()
    {
        $dbManager = $this->createMock(DatabaseManager::class);
        $connection = $this->createMock(SQLiteConnection::class);
        $dbManager->method('connection')->with('sqlite')->willReturn($connection);
        $connectionFactory = new SQLiteConnectionFactory($dbManager);

        $this->assertInstanceOf(SQLiteConnection::class, $connectionFactory->create());
    }
}
