<?php

namespace App\ApiResource;
    use App\Validator\UnregistredEmail;
    use Symfony\Component\Validator\Constraints as Assert;


class CreateUser
{
        #[Assert\Email]
        #[UnregistredEmail]
        public ?string $email = null;

        #[Assert\NotBlank]
        #[Assert\Length(min: 6)]
        public ?string $password = null;
}
