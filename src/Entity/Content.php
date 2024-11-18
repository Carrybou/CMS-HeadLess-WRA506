<?php

namespace App\Entity;

use App\Doctrine\Traits\UuidTrait;
use App\Repository\ContentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Doctrine\Traits\TimestampableTrait;

#[ORM\Entity(repositoryClass: ContentRepository::class)]
class Content
{
    use UuidTrait, TimestampableTrait;

    #[ORM\Column(length: 255)]
    private ?string $Title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $img = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $meta = null;

    #[ORM\Column(length: 255)]
    private ?string $content = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    /**
     * @var Collection<int, Tags>
     */
    #[ORM\ManyToMany(targetEntity: Tags::class)]
    #[ORM\JoinTable(name: 'content_tags', joinColumns: [new ORM\JoinColumn(name: 'content_uuid', referencedColumnName: 'uuid')], inverseJoinColumns: [new ORM\JoinColumn(name: 'tag_uuid', referencedColumnName: 'uuid')])]
    private Collection $tags;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false, referencedColumnName: 'uuid')]
    private ?User $Author = null;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }


    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): static
    {
        $this->Title = $Title;

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(?string $img): static
    {
        $this->img = $img;

        return $this;
    }

    public function getMeta(): ?string
    {
        return $this->meta;
    }

    public function setMeta(?string $meta): static
    {
        $this->meta = $meta;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
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

    public function getAuthor(): ?User
    {
        return $this->Author;
    }

    public function setAuthor(?User $Author): static
    {
        $this->Author = $Author;

        return $this;
    }

    public function getDcrt(): ?\DateTimeInterface
    {
        return $this->Dcrt;
    }

    public function setDcrt(\DateTimeInterface $Dcrt): static
    {
        $this->Dcrt = $Dcrt;

        return $this;
    }

    public function getDmod(): ?\DateTimeInterface
    {
        return $this->Dmod;
    }

    public function setDmod(?\DateTimeInterface $Dmod): static
    {
        $this->Dmod = $Dmod;

        return $this;
    }
}
