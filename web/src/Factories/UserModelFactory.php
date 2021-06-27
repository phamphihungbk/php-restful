<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
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
            'id' => $this->faker->unique()->uuid,
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => bcrypt('test@testxxx'),
            'remember_token' => Str::random(10),
            'facebook' => 'facebook.com',
            'twitter' => 'twitter.com',
        ];
    }
}
