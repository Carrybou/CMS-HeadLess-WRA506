<?php

namespace App\Service;

use App\Entity\Content;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class SlugService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private SluggerInterface $slugger,
    ) {
    }

    public function generateUniqueSlug(string $title): string
    {
        $slug = $this->slugger->slug($title)->lower();
        return $this->ensureUniqueSlug($slug);
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
