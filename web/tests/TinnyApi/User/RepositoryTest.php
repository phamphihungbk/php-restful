<?php


namespace Tests\TinnyApi\User;

use PHPUnit\Framework\TestCase;
use TinnyApi\User\Repository;
use TinnyApi\User\Resource\UserResource;

class RepositoryTest extends TestCase
{
    /**
     * @test
     */
    public function getAllTest()
    {
        $userRepository = new Repository();
        $userRepository->getAll();
        $this->assertInstanceOf(UserResource::class, $userRepository->getAll());
    }


    public function updateTest()
    {
    }


    public function storeTest()
    {
    }


    public function selectTest()
    {
    }


    public function deleteTest()
    {
    }
}
