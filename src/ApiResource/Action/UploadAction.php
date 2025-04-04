<?php declare(strict_types=1);

namespace App\ApiResource\Action;

use App\Entity\Upload;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use const PATHINFO_FILENAME;

#[AsController]
class UploadAction
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private FileUploader $fileUploader,
    ) {
    }

    public function __invoke(Request $request): Upload
    {
        $file = $request->files->get('file');

        if (!$file) {
            throw new BadRequestHttpException('No file uploaded.');
        }

        $filename = $this->fileUploader->upload($file);
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        $upload = new Upload();
        $upload->path = "/medias/{$filename}";
        $upload->title = $originalFilename;

        $this->entityManager->persist($upload);
        $this->entityManager->flush();

        return $upload;
    }
}
