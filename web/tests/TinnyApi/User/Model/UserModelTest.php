<?php

namespace Tests\TinnyApi\User\Model;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use TinnyApi\User\Model\UserModel;

class UserModelTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function databaseTest()
    {
        $users = UserModel::factory()->create();
        $this->assertEquals(1, $this->count($users->toArray()));
        $this->assertDatabaseCount('users', 1);
    }
}
