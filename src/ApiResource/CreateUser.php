<?php

namespace App\ApiResource;
    use App\Validator\UnregistredEmail;


class CreateUser
{
        #[UnregistredEmail]
        public ?string $email = null;

        public ?string $password = null;
}
