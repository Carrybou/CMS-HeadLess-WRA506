<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\ApiResource\ContentProcessor;
use App\Doctrine\Traits\UuidTrait;
use App\Repository\ContentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Doctrine\Traits\TimestampableTrait;
use Symfony\Component\Validator\Constraints as Assert;


#[Get(uriVariables: ['slug'])]
#[GetCollection]
#[Put(uriVariables: ['slug'], security: 'is_granted("ROLE_ADMIN") and object.author == user')]
#[Delete(uriVariables: ['slug'], security: 'is_granted("ROLE_ADMIN") and object.author == user')]
#[ApiFilter(SearchFilter::class, properties: ['title' => 'partial'])] # < cette ligne permet de filtrer les données par titre dans l'API
#[Post(uriVariables: ['slug'], security: 'is_granted("ROLE_USER")', processor: ContentProcessor::class)] # cette annotation nous transforme en API
#[ORM\Entity(repositoryClass: ContentRepository::class)]
class Content
{
    use UuidTrait, TimestampableTrait;


    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 1, max: 255)]
    public ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank]
    public ?string $img = null;

    #[ORM\Column(length: 255, nullable: true)]
    public ?string $meta = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    public ?string $content = null;

    #[ORM\Column(length: 255, unique: true)]
    public ?string $slug = null;

    /**
     * @var Collection<int, Tags>
     */
    #[ApiProperty(readableLink: true)]
    #[ORM\ManyToMany(targetEntity: Tags::class)]
    #[ORM\JoinTable(name: 'content_tags', joinColumns: [new ORM\JoinColumn(name: 'content_uuid', referencedColumnName: 'uuid')], inverseJoinColumns: [new ORM\JoinColumn(name: 'tag_uuid', referencedColumnName: 'uuid')])]
    public Collection $tags;


    #[ORM\ManyToOne]
    #[ApiProperty(identifier: false)]
    #[ORM\JoinColumn(nullable: false, referencedColumnName: 'uuid', onDelete: 'CASCADE')]
    public ?User $author = null;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->defineUuid();
    }

    /**
     * @return Collection<int, Tags>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tags $tag): static
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
        }

        return $this;
    }

    public function removeTag(Tags $tag): static
    {
        $this->tags->removeElement($tag);

        return $this;
    }

}
