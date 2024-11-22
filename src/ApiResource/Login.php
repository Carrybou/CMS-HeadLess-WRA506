<?php declare(strict_types=1);

namespace App\ApiResource;

use ApiPlatform\Metadata\Post;

#[Post(uriTemplate: '/api/login', routeName: 'api_security_login', output: Token::class)]
class Login
{
    public ?string $email = null;
    public ?string $password = null;
}
