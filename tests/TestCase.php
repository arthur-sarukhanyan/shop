<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations, RefreshDatabase;

    protected bool $seed = true;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::first();
    }
}
