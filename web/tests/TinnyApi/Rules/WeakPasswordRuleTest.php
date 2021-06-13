<?php

namespace Tests\TinnyApi\Rules;

use Illuminate\Support\Collection;
use Tests\TestCase;
use TinnyApi\Rules\WeakPasswordRule;
use Illuminate\Cache\Repository as CacheRepository;

class WeakPasswordRuleTest extends TestCase
{
    private $rule;

    /**
     * @var CacheRepository|\PHPUnit\Framework\MockObject\MockObject
     */
    private $cacheRepository;

    /**
     * @var Collection
     */
    private $rules;

    public function setUp(): void
    {
        $this->cacheRepository = $this->getMockBuilder(CacheRepository::class)
            ->disableOriginalConstructor()->setMethods(['rememberForever'])->getMock();
        $this->rule = new WeakPasswordRule($this->cacheRepository);
        $this->cacheRepository->method('rememberForever')
            ->withAnyParameters()->willReturn(new Collection(['testpassword', 'password', 'weekpassword']));
    }

    /**
     * @test
     */
    public function testWillPassBecausePasswordIsNotInWeakPasswordList()
    {
        $result = $this->rule->passes('password', 'skjdfksf233ksjd');
        $this->assertTrue($result);
    }

    /**
     * @test
     */
    public function testWillNotPassBecausePasswordIsInWeakPasswordList()
    {
        $this->assertFalse($this->rule->passes('password', 'password'));
    }
}
