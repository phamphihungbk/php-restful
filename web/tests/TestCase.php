<?php

namespace Tests;

use DateTime;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\ClientRepository;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase, DatabaseMigrations, WithoutMiddleware;

    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate');
        $clientRepository = new ClientRepository();
        $time = new DateTime;
        $client = $clientRepository->createPersonalAccessClient(null, 'Test Personal Access Client', '/');
        DB::table('oauth_personal_access_clients')->insert([
            'client_id' => $client->id,
            'created_at' => $time,
            'updated_at' => $time,
        ]);
    }
}
