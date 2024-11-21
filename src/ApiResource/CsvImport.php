<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\ApiResource\Action\CsvImportAction;
use Doctrine\ORM\Mapping as ORM;
#[ORM\Entity]
#[Post(uriVariables: ['slug'], controller: CsvImportAction::class, security: 'is_granted("ROLE_ADMIN")', deserialize: false)]
class CsvImport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = 1;

    #[ORM\Column(type: 'boolean', nullable: true)]
    public ?bool $isSuccess;

    public function getId(): ?int
    {
        return $this->id;
    }
}
