<?php

namespace App\Entity;

use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\ApiResource\Action\UploadAction;
use App\Doctrine\Traits\TimestampableTrait;
use App\Doctrine\Traits\UuidTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[Get]
#[GetCollection]
#[Put(security: 'is_granted("ROLE_ADMIN") and object.author == user')]
#[Delete(security: 'is_granted("ROLE_ADMIN") and object.author == user')]
#[Post(controller: UploadAction::class, deserialize: false)]
class Upload
{
    use UuidTrait, TimestampableTrait;

    #[ORM\Column]
    public ?string $path = null;

    public function __construct()
    {
        $this->defineUuid();
    }
}