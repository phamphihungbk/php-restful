<?php

namespace Tests\TinnyApi\Rules;

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
        $this->user = UserModel::factory()->create();
        $this->rule = new CurrentPasswordRule();
    }

    /**
     * @test
     */
    public function testWillPassBecausePasswordMatch()
    {
        $this->be($this->user);
        $this->assertTrue($this->rule->passes('current_password', 'secretxxx'));
    }

    /**
     * @test
     */
    public function testWillNotPassBecausePasswordNotMatch()
    {
        $this->be($this->user);
        $this->assertFalse($this->rule->passes('current_password', 'skjdfksf233ksjd'));
    }
}
