<?php declare(strict_types=1);

namespace App\ApiResource;

use ApiPlatform\Metadata\Post;
use App\ApiResource\Action\CsvImportAction;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[Post(uriVariables: ['slug'], controller: CsvImportAction::class, security: 'is_granted("ROLE_ADMIN")', deserialize: false)]
class CsvImport
{
    #[ORM\Column(type: 'boolean', nullable: true)]
    public ?bool $isSuccess;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = 1;

    public function getId(): ?int
    {
        return $this->id;
    }
}
