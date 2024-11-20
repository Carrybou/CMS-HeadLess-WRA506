<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Content;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\String\Slugger\SluggerInterface;

class ContentProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private SluggerInterface $slugger,
        private Security $security,
    ) {
    }

    public function process(
        $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = []
    ): Content
    {

        if ($data instanceof Content) {
            $slug = $this->slugger->slug($data->title)->lower();
            $uniqueSlug = $this->ensureUniqueSlug($slug);
            $data->slug=$uniqueSlug;

            $data->author = $this->security->getUser();

            $this->entityManager->persist($data);
            $this->entityManager->flush();
        }
        return $data;

    }

    private function ensureUniqueSlug(string $slug): string
    {
        $repository = $this->entityManager->getRepository(Content::class);
        $i = 1;
        $uniqueSlug = $slug;
        while ($repository->findOneBy(['slug' => $uniqueSlug])) {
            $uniqueSlug = $slug . '-' . $i++;
        }
        return $uniqueSlug;
    }
}
