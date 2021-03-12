<?php


namespace Tests\TinnyApi\User;

use Illuminate\Database\Connection;
use Tests\TestCase;
use TinnyApi\User\Model\UserModel;
use TinnyApi\User\Repository;
use TinnyApi\User\Resource\UserResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RepositoryTest extends TestCase
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|UserModel
     */
    private $users;

    protected function setUp(): void
    {
        parent::setUp();
        $this->users = $this->createMock(UserModel::class);
    }

    /**
     * @test
     */
    public function getAllTest()
    {
        $this->users->method('all');
        $userRepository = new Repository();
        $this->assertInstanceOf(UserResource::class, $userRepository->getAll());
    }

    /**
     * @test
     * @dataProvider updateTestDataProvider
     * @param string $email
     * @param $request
     */
    public function updateTest(string $email, $request)
    {
        $new =  $this->users
            ->method('findOrFail')
            ->with($email)->willReturn($request);
    }

    public function updateTestDataProvider(): array
    {
        return [
            [
                'email' => '',
                'request' => $this->createMock(Connection::class),
            ],
            [
                'email' => '',
                'request' => $this->createMock(ModelNotFoundException::class),
            ],
        ];
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
