<?php declare(strict_types=1);

namespace App\ApiResource;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Content;
use App\Entity\User;
use App\Service\SlugService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

class ContentProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private Security $security,
        private SlugService $slugService,
    ) {
    }

    public function process(
        $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = [],
    ): Content {
        if ($data instanceof Content) {
            $data->slug = $this->slugService->generateUniqueSlug($data->title);
            $user = $this->security->getUser();
            if ($user instanceof User) {
                $data->author = $user;
            }
            $this->entityManager->persist($data);
            $this->entityManager->flush();
        } else {
            dd('Data is not an instance of Content', $data);
        }

        return $data;
    }
}
