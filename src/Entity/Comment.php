<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\ApiResource\CommentProcessor;
use App\ApiResource\ContentProcessor;
use App\Repository\CommentRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Doctrine\Traits\UuidTrait;
use App\Doctrine\Traits\TimestampableTrait;
use Symfony\Component\Serializer\Annotation\Groups;

#[Get]
#[GetCollection]
#[Post( security: 'is_granted("ROLE_USER")',processor: CommentProcessor::class)] # cette annotation nous transforme en API
#[Put(security: 'is_granted("ROLE_ADMIN") and object.author == user', denormalizationContext: ['groups' => ['comment:update']])]
#[Delete(security: 'is_granted("ROLE_ADMIN") and object.author == user')]
#[ApiFilter(SearchFilter::class, properties: ['txt' => 'partial'])]
#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    use UuidTrait, TimestampableTrait;
    #[ORM\Column(length: 255)]
    #[Groups(['comment:update'])]
    public ?string $txt = null;

    #[ORM\ManyToOne]
    #[ApiProperty(identifier: false)]
    #[ORM\JoinColumn(nullable: false, referencedColumnName: 'uuid', onDelete: 'CASCADE')]
    public ?User $author = null;


    #[ApiProperty(readableLink: true)]
    #[ORM\ManytoOne(targetEntity: Content::class)]
    #[ORM\JoinColumn(nullable: false, referencedColumnName: 'uuid', onDelete: 'CASCADE')]
    public ?Content $content;
    public function __construct()
    {
        $this->defineUuid();
    }

}
