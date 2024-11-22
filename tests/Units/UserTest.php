<?php

namespace App\Tests\Units;

use PHPUnit\Framework\TestCase;
use App\Entity\User;

class UserTest extends TestCase
{
    public function testGetRoles()
    {
        $user = new User();

        $roles = $user->getRoles();

        $this->assertIsArray($roles, 'Roles should be an array');
        $this->assertContains('ROLE_USER', $roles, 'Roles should contain ROLE_USER');
    }
}
