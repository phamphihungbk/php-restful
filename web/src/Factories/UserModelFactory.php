<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;
use TinnyApi\Models\UserModel;

class UserModelFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = UserModel::class;

    /**
     * @return array
     */
    public function definition()
    {
        return [
            'id' => 'user_id',
            'name' => $this->faker->name,
            'email_token_confirmation' => 'email_token',
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'remember_token' => Str::random(10),
            'facebook' => 'facebook.com',
            'twitter' => 'twitter.com',
        ];
    }
}
