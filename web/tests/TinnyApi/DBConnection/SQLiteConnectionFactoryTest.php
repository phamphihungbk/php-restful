<?php

namespace Tests\TinnyApi\DBConnection;

use Illuminate\Database\Connection;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\SQLiteConnection;
use Tests\TestCase;
use TinnyApi\DBConnection\SQLiteConnectionFactory;

class SQLiteConnectionFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function createTest()
    {
        $dbManager = $this->createMock(DatabaseManager::class);
        $dbManager->method('connection')->with('sqlite')->willReturn($this->createMock(SQLiteConnection::class));
        $factory = new SQLiteConnectionFactory($dbManager);

        $this->assertInstanceOf(Connection::class, $factory->create());
    }
}
