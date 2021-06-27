<?php

namespace Tests\TinnyApi\Controllers;

use DateTime;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\ClientRepository;
use Tests\TestCase;
use TinnyApi\Models\UserModel as User;

class LoginControllerTest extends TestCase
{
    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    private $user;

    public function setUp(): void
    {
        parent::setUp();
        $clientRepository = new ClientRepository();
        $time = new DateTime;
        $client = $clientRepository->createPersonalAccessClient(null, 'Test Personal Access Client', '/');
        DB::table('oauth_access_tokens')->insert([
            'client_id' => $client->id,
            'created_at' => $time,
            'updated_at' => $time,
        ]);
        $this->user = User::factory()->create();
    }

    /**
     * @test
     */
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

    /**
     * @test
     */
    public function testFetchTheCurrentUser()
    {
        $accessToken = $this->postJson(route('api.auth.login'), [
            'email' => $this->user->email,
            'password' => 'test@testxxx',
        ])->json()['data']['access_token'];

        $this->getJson(route('api.me'), ['Authorization' => 'Bearer ' . $accessToken])
            ->assertOk()
            ->assertJsonFragment([
                'id' => $this->user->id,
                'email' => $this->user->email,
                'name' => $this->user->name,
                'facebook' => $this->user->facebook,
                'twitter' => $this->user->twitter,
            ]);
    }

    /**
     * @test
     */
    public function testLogout()
    {
        $accessToken = $this->postJson(route('api.auth.login'), [
            'email' => $this->user->email,
            'password' => 'test@testxxx',
        ])->json()['data']['access_token'];

        $this->postJson(route('api.auth.logout'), [], ['Authorization' => 'Bearer ' . $accessToken])
            ->assertSuccessful();

//        $this->getJson(route('api.me'), ['Authorization' => 'Bearer ' . $accessToken])
//            ->assertUnauthorized();
    }
}
