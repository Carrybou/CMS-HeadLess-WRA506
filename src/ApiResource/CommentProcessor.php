<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Comment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\String\Slugger\SluggerInterface;

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
        array $context = []
    ): Comment
    {

        if ($data instanceof Comment) {


            $data->author = $this->security->getUser();

            $this->entityManager->persist($data);
            $this->entityManager->flush();
        }
        return $data;

    }

}
