<?php

namespace App\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;

#[Post(uriTemplate: '/api/login', routeName: 'api_security_login', output: Token::class)]
class Login
{
    public ?string $email = null;
    public ?string $password = null;
}
