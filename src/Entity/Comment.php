<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Doctrine\Traits\UuidTrait;
use App\Doctrine\Traits\TimestampableTrait;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    use UuidTrait, TimestampableTrait;
    #[ORM\Column(length: 255)]
    private ?string $txt = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false, referencedColumnName: 'uuid')]
    private ?User $author = null;



    public function getTxt(): ?string
    {
        return $this->txt;
    }

    public function setTxt(string $txt): static
    {
        $this->txt = $txt;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): static
    {
        $this->author = $author;

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
