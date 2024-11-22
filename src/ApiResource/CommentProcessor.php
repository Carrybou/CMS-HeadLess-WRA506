<?php declare(strict_types=1);

namespace App\ApiResource;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Comment;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

class CommentProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private Security $security,
    ) {
    }

    public function process(
        $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = [],
    ): Comment {
        if ($data instanceof Comment) {
            $user = $this->security->getUser();
            if ($user instanceof User) {
                $data->author = $user;
            }
            $this->entityManager->persist($data);
            $this->entityManager->flush();
        }

        return $data;
    }
}
