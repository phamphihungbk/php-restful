<?php

namespace Tests\TinnyApi\Controllers;

use Tests\TestCase;
use TinnyApi\Models\UserModel as User;

class LoginControllerTest extends TestCase
{
    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    private $user;

    const HTTP_LOCKED = 423;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->user->createToken('Test Personal Access Client');
        dd($this->user);
    }

    public function testLogin()
    {
        $this->postJson(route('api.auth.login'), [
            'email' => $this->user->email,
            'password' => 'test@testxxx',
        ])
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    'access_token',
                    'token_type',
                    'expires_at',
                ],
                'meta' => [
                    'status',
                    'timestamp',
                ],
            ]);
    }

    public function testFetchTheCurrentUser()
    {
        $this->actingAs($this->user)
            ->getJson(route('api.me'))
            ->assertOk()
            ->assertJsonFragment([
                'email' => $this->user->email,
                'locale' => $this->user->locale,
            ]);
    }

    /**
     * @group logout
     */
    public function testLogout()
    {
        $token = $this->postJson(route('api.auth.login'), [
            'email' => $this->user->email,
            'password' => 'secretxxx',
        ])->json()['data']['token'];

        $this->postJson(route('api.auth.logout') . '?token=' . $token)
            ->assertSuccessful();

        $this->getJson(route('api.me') . '?token=' . $token)
            ->assertUnauthorized();
    }

    public function testCannotLoginBecauseEmailIsNotVerified()
    {
        $this->user = User::factory()->emailUnverified()->create();

        $this->postJson(route('api.auth.login'), [
            'email' => $this->user->email,
            'password' => 'secretxxx',
        ])
            ->assertStatus(self::HTTP_LOCKED);
    }

    public function testCannotLoginBecauseAccountIsInactive()
    {
        $this->user = User::factory()->inactive()->create();

        $this->postJson(route('api.auth.login'), [
            'email' => $this->user->email,
            'password' => 'secretxxx',
        ])
            ->assertStatus(self::HTTP_LOCKED);
    }
}
