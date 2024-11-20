<?php

namespace App\Entity;

use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\TagsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Doctrine\Traits\UuidTrait;
use App\Doctrine\Traits\TimestampableTrait;
#[Post(security: 'is_granted("ROLE_USER")')] # cette annotation nous transforme en API
#[Get]
#[GetCollection]
#[Put]
#[Delete]
#[ORM\Entity(repositoryClass: TagsRepository::class)]
class Tags
{
    use UuidTrait, TimestampableTrait;
    #[ORM\Column(length: 255)]
    public ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    public ?string $color = null;
    public function __construct()
    {
        $this->defineUuid();
    }
}
