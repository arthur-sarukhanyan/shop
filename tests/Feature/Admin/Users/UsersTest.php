<?php

namespace Admin\Users;

use Tests\TestCase;

class UsersTest extends TestCase
{
    /**
     * Check super admin always exists
     */
    public function testAdmin(): void
    {
        $this->assertDatabaseHas('users', [
            'email' => 'admin@gmail.com',
            'level' => 1,
        ]);
    }
}
