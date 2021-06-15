<?php

namespace Tests\TinnyApi\Controllers;

use Illuminate\Http\Response;
use Tests\TestCase;
use TinnyApi\Models\UserModel;

class RegisterControllerTest extends TestCase
{
    const REGISTER_ROUTER = 'api.auth.register';

    /**
     * @test
     */
    public function testCanRegister()
    {
        $this->postJson(route(self::REGISTER_ROUTER), [
            'name' => 'test',
            'email' => 'test@test.com',
            'password' => 'secretxxx-test',
            'password_confirmation' => 'secretxxx-test',
        ])
            ->assertStatus(Response::HTTP_CREATED)
            ->assertSee('We sent a confirmation email to test@test.com');
    }

    /**
     * @test
     */
    public function testCannotRegisterBecausePasswordIsTooShort()
    {
        $this->postJson(route(self::REGISTER_ROUTER), [
            'name' => 'test',
            'email' => 'test@test.com',
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertSee('The given data was invalid.');
    }

    /**
     * @test
     */
    public function testCannotRegisterBecausePasswordIsWeak()
    {
        $this->postJson(route(self::REGISTER_ROUTER), [
            'name' => 'test',
            'email' => 'test@test.com',
            'password' => 'secretxxx',
            'password_confirmation' => 'secretxxx',
        ])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertSee('The given data was invalid.');
    }

    /**
     * @test
     */
    public function testCannotRegisterBecausePasswordsNotMatch()
    {
        $this->postJson(route(self::REGISTER_ROUTER), [
            'name' => 'test',
            'email' => 'test@test.com',
            'password' => 'secretxxx1',
            'password_confirmation' => 'secretxxx2',
        ])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertSee('The given data was invalid.');
    }

    /**
     * @test
     */
    public function testCannotRegisterBecauseEmailAlreadyRegistered()
    {
        UserModel::factory()->create([
            'email' => 'test@test.com',
            'password' => bcrypt('secretxxx'),
        ]);

        $this->postJson(route(self::REGISTER_ROUTER), [
            'email' => 'test@test.com',
            'password' => 'secretxxx-test',
            'password_confirmation' => 'secretxxx-test',
        ])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertSee('The given data was invalid.');
    }
}
