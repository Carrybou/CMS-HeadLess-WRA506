<?php declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Doctrine\Traits\TimestampableTrait;
use App\Doctrine\Traits\UuidTrait;
use App\Repository\TagsRepository;
use Doctrine\ORM\Mapping as ORM;

#[Post(security: 'is_granted("ROLE_ADMIN")')] // cette annotation nous transforme en API
#[Get]
#[GetCollection]
#[Put(security: 'is_granted("ROLE_ADMIN")')]
#[Delete(security: 'is_granted("ROLE_ADMIN")')]
#[ApiFilter(SearchFilter::class, properties: ['name' => 'partial'])]
#[ORM\Entity(repositoryClass: TagsRepository::class)]
class Tags
{
    use UuidTrait;
    use TimestampableTrait;
    #[ORM\Column(length: 255)]
    public ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    public ?string $color = null;

    public function __construct()
    {
        $this->defineUuid();
    }
}
