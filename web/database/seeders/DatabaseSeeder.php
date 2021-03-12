<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use TinnyApi\User\Model\UserModel;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        UserModel::factory()->count(10)->create();
    }
}
