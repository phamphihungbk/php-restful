<?php


namespace Tests\TinnyApi\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use TinnyApi\User\Model\UserModel;
use TinnyApi\User\Repository;
use TinnyApi\User\Resource\UserResource;
use Tests\TestCase;

class RepositoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|UserModel
     */
    private $userModel;

    /**
     * @var Repository
     */
    private $userRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $data = [
            'name' => 'Chelsie Romaguera',
            'email' => 'missouri62223@example.net',
            'email_verified_at' => '2021-03-12T03:39:06.000000Z',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'remember_token' => '563hgjzk35',
        ];
        $this->userModel = $this->getMockBuilder(UserModel::class)
            ->setMethods(['all', 'findOrFail', 'update', 'create', 'delete'])
            ->getMock();
        UserModel::factory()->create($data);
        $this->userRepository = new Repository();
    }

    /**
     * @test
     */
    public function getAllTest()
    {
        $this->userModel->method('all');
        $this->assertInstanceOf(UserResource::class, $this->userRepository->getAll());
    }

    /**
     * @test
     * @dataProvider updateTestDataProvider
     * @param string $email
     * @param array $request
     */
    public function updateTest(string $email, array $request)
    {
        $this->userModel
            ->method('findOrFail')
            ->with($email)->willReturnSelf();
        $this->userModel->expects($this->never())
            ->method('update')->with($request)->willReturnSelf();
        $this->userRepository->update($email, $request);
    }

    public function updateTestDataProvider(): array
    {
        return [
            [
                'email' => 'missouri62223@example.net',
                'request' => [
                    'name' => 'Updated name',
                    'email' => 'updated@example.net',
                    'email_verified_at' => '2021-03-12T03:39:06.000000Z',
                    'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                    'remember_token' => '563hgjzk35',
                ]
            ],
            [
                'email' => 'missouri62223@example.net',
                'request' => [
                    'name' => 'Updated name',
                    'email' => 'updated@example.net',
                    'email_verified_at' => '2021-03-12T03:39:06.000000Z',
                    'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                    'remember_token' => '563hgjzk35',
                ]
            ],
        ];
    }

    /**
     * @test
     */
    public function storeTest()
    {
        $data = [
            'name' => 'Store',
            'email' => 'store@example.net',
            'email_verified_at' => '2021-03-12T03:39:06.000000Z',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'remember_token' => '563hgjzk35',
        ];
        $this->userModel->expects($this->never())->method('create')->with($data);
        $this->userRepository->store($data);
    }

    /**
     * @test
     */
    public function selectTest()
    {
        $email = 'missouri62223@example.net';
        $this->userModel->method('findOrFail')->with($email)->willReturnSelf();
        $this->assertInstanceOf(UserResource::class, $this->userRepository->select($email));
    }

    /**
     * @test
     */
    public function deleteTest()
    {
        $email = 'missouri62223@example.net';
        $this->userModel->method('findOrFail')->with($email)->willReturnSelf();
        $this->userModel->expects($this->never())->method('delete');
        $this->userRepository->delete($email);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->userModel = null;
    }
}
