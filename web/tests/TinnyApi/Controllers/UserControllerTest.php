<?php

namespace Tests\TinnyApi\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use TinnyApi\Models\UserModel;

class UserControllerTest extends TestCase
{
    /**
     * @var UserModel
     */
    private $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = UserModel::factory()->create();
    }

    /**
     * @test
     * @group index
     * @group crud
     */
    public function testIndex()
    {
        $includes = [];

        $this->actingAs($this->user)
            ->getJson(route('api.users.index') . '?include=' . implode(',', $includes))
            ->assertOk()
            ->assertSeeText('loginHistories')
            ->assertSeeText('authorizedDevices')
            ->assertSeeText('notifications')
            ->assertSeeText('unreadNotifications');
    }

    /**
     * @test
     * @group index
     * @group crud
     */
    public function testCannotIndexBecauseInvalidInclude()
    {

        $includes = [];

        $this->actingAs($this->user)
            ->getJson(route('api.users.index') . '?include=' . implode(',', $includes))
            ->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertSeeText('Allowed include(s) are');
    }

    /**
     * @test
     * @group index
     * @group crud
     * @group unauthenticated
     */
    public function testCannotIndexBecauseUnauthenticated()
    {
        $this->getJson(route('api.users.index'))
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @test
     * @group index
     * @group crud
     * @group unauthorized
     */
    public function testCannotIndexBecauseUnauthorized()
    {
        $this
            ->actingAs($this->user)
            ->getJson(route('api.users.index'))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * @test
     * @group show
     * @group crud
     */
    public function testShowMe()
    {
        $includes = [];

        $this->actingAs($this->user)
            ->getJson(route('api.me') . '?include=' . implode(',', $includes))
            ->assertOk()
            ->assertSeeText('loginHistories')
            ->assertSeeText('authorizedDevices')
            ->assertSeeText('notifications')
            ->assertSeeText('unreadNotifications');
    }

    /**
     * @group show
     * @group crud
     */
    public function testShow()
    {

        $includes = [];

        $user2 = UserModel::factory()->create();

        $this->actingAs($this->user)
            ->getJson(route('api.users.show', $user2->id) . '?include=' . implode(',', $includes))
            ->assertOk()
            ->assertSeeText('loginHistories')
            ->assertSeeText('authorizedDevices')
            ->assertSeeText('notifications')
            ->assertSeeText('unreadNotifications');
    }

    /**
     * @test
     * @group show
     * @group crud
     */
    public function testCannotShowBecauseModelNotFound()
    {
        $this->actingAs($this->user)
            ->getJson(route('api.users.show', Uuid::uuid4()->toString()))
            ->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertSeeText('The requested resource was not found');
    }

    /**
     * @test
     * @group show
     * @group crud
     * @group unauthenticated
     */
    public function testCannotShowBecauseUnauthenticated()
    {
        $this->getJson(route('api.users.show', $this->user->id))
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @test
     * @group show
     * @group crud
     * @group unauthorized
     */
    public function testCannotShowBecauseUnauthorized()
    {
        $user2 = UserModel::factory()->create();

        $this->actingAs($this->user)
            ->getJson(route('api.users.show', $user2->id))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * @test
     * @group update
     * @group crud
     */
    public function testUpdateMe()
    {
        $this->actingAs($this->user)
            ->patchJson(route('api.me.update'), [
                'email' => 'test@test.com',
            ])
            ->assertSuccessful()
            ->assertJsonFragment([
                'email' => 'test@test.com',
            ]);
    }

    /**
     * @test
     * @group update
     * @group crud
     * @group unauthorized
     */
    public function testCannotUpdateBecauseUnauthorized()
    {

        $user2 = UserModel::factory()->create();

        $this->actingAs($this->user)
            ->patchJson(route('api.users.update', $user2->id), [
                'email' => 'test@test.com',
            ])
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * @test
     * @group password
     */
    public function testUpdatePassword()
    {
        $this->actingAs($this->user)
            ->patchJson(route('api.password.update'), [
                'current_password' => 'secretxxx',
                'password' => 'ksjd2ksdjf',
                'password_confirmation' => 'ksjd2ksdjf',
            ])
            ->assertSuccessful();

        $this->user->refresh();

        $this->assertTrue(Hash::check('ksjd2ksdjf', $this->user->password));
    }

    /**
     * @test
     * @group password
     */
    public function testCannotUpdatePasswordBecauseCurrentPasswordIsInvalid()
    {
        $this->actingAs($this->user)
            ->patchJson(route('api.password.update'), [
                'current_password' => 'secret123',
                'password' => 'secretxxx',
                'password_confirmation' => 'secretxxx',
            ])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertSee('Your current password is not valid');
    }

    /**
     * @test
     * @group password
     */
    public function testCannotUpdatePasswordBecausePasswordIsTooShort()
    {
        $this->actingAs($this->user)
            ->patchJson(route('api.password.update'), [
                'current_password' => 'secretxxx',
                'password' => 'secret',
                'password_confirmation' => 'secret',
            ])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertSee('The password must be at least 8 characters');
    }

    /**
     * @test
     * @group password
     */
    public function testCannotUpdatePasswordBecausePasswordsNotMatch()
    {
        $this->actingAs($this->user)
            ->patchJson(route('api.password.update'), [
                'current_password' => 'secretxxx',
                'password' => 'secret1',
                'password_confirmation' => 'secret2',
            ])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertSee('The password confirmation does not match');
    }

    /**
     * @test
     * @group update
     * @group crud
     */
    public function testCannotUpdateAntiPhishingCodeBecauseNotAlphaDash()
    {
        $this->actingAs($this->user)
            ->patchJson(route('api.me.update'), [
                'anti_phishing_code' => 'Test ***',
            ])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
