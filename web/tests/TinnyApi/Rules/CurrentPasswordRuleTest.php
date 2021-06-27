<?php

namespace Tests\TinnyApi\Rules;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Hashing\HashManager;
use Tests\TestCase;
use TinnyApi\Models\UserModel;
use TinnyApi\Rules\CurrentPasswordRule;

class CurrentPasswordRuleTest extends TestCase
{
    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    private $user;

    /**
     * @var CurrentPasswordRule
     */
    private $rule;


    public function setUp(): void
    {
        parent::setUp();
        $this->user = UserModel::factory()->create();
        $this->rule = new CurrentPasswordRule(
            $this->createMock(HashManager::class),
            $this->createMock(Guard::class)
        );
    }

    /**
     * @test
     */
    public function testWillPassBecausePasswordMatch()
    {
        $this->actingAs($this->user, 'api');
        $this->assertTrue($this->rule->passes('current_password', 'test@testxxx'));
    }

    /**
     * @test
     */
    public function testWillNotPassBecausePasswordNotMatch()
    {
        $this->actingAs($this->user, 'api');
        $this->assertFalse($this->rule->passes('current_password', 'skjdfksf233ksjd'));
    }
}
