<?php

namespace App\ApiResource\Action;

use App\Entity\Upload;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

#[AsController]
class UploadAction
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private FileUploader $fileUploader,
    ) {
    }

    public function __invoke(Request $request)
    {
        $file = $request->files->get('file');

        if (!$file) {
            throw new BadRequestHttpException('No file uploaded.');
        }

        $filename = $this->fileUploader->upload($file);

        $upload = new Upload();
        $upload->path = "/medias/{$filename}";

        $this->entityManager->persist($upload);
        $this->entityManager->flush();

        return $upload;
    }
}
