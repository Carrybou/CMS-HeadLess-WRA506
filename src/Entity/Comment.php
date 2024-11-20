<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\ApiResource\ContentProcessor;
use App\Repository\CommentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Doctrine\Traits\UuidTrait;
use App\Doctrine\Traits\TimestampableTrait;
#[Get]
#[GetCollection]
#[Post( security: 'is_granted("ROLE_USER")')] # cette annotation nous transforme en API
#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    use UuidTrait, TimestampableTrait;
    #[ORM\Column(length: 255)]
    public ?string $txt = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false, referencedColumnName: 'uuid')]
    public ?User $author = null;

    public function __construct()
    {
        $this->defineUuid();
    }

}
