<?php declare(strict_types=1);

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
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[Get]
#[GetCollection]
#[Put(security: 'is_granted("ROLE_ADMIN") and object.author == user')]
#[Delete(security: 'is_granted("ROLE_ADMIN") and object.author == user')]
#[Post(controller: UploadAction::class, deserialize: false)]
class Upload
{
    use UuidTrait;
    use TimestampableTrait;

    #[ORM\Column]
    #[Assert\NotBlank]
    public ?string $path = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    public ?string $title = null;

    public function __construct()
    {
        $this->defineUuid();
    }
}
