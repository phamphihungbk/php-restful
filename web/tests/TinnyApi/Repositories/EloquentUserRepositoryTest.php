<?php

namespace Tests\TinnyApi\Repositories;

use Tests\TestCase;
use TinnyApi\Contracts\UserRepository;
use TinnyApi\Models\UserModel;

class EloquentUserRepositoryTest extends TestCase
{
    private $user;

    private $userRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = UserModel::factory()->create();
        $this->userRepository = $this->createMock(UserRepository::class);
    }


}
