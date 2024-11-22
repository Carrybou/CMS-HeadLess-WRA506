<?php

namespace App\Service;

use App\ApiResource\ContentProcessor;
use App\Entity\Content;
use App\Entity\Tags;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CsvImporter
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private FileUploader $fileUploader,
        private ContentProcessor $contentProcessor,
        private SlugService $slugService,
        private Security $security,

    ) {
    }

    public function import(string $filePath): void
    {
        if (!file_exists($filePath) || !is_readable($filePath)) {
            throw new BadRequestHttpException('CSV file is not readable.');
        }

        $handle = fopen($filePath, 'r');
        if ($handle === false) {
            throw new BadRequestHttpException('Failed to open CSV file.');
        }

        $header = fgetcsv($handle, 1000, ',');
        if ($header === false) {
            throw new BadRequestHttpException('Invalid CSV file format.');
        }

        while (($row = fgetcsv($handle, 1000, ',')) !== false) {
            $data = array_combine($header, $row);
            $this->processRow($data);
        }

        fclose($handle);
    }

    private function processRow(array $data): void
    {
        $content = new Content();
        $content->author = $this->security->getUser();
        $content->title = $data['title'] ?? null;
        $content->img = $this->downloadImage($data['cover']);
        $content->meta_title = $data['meta_title'] ?? null;
        $content->meta_description = $data['meta_description'] ?? null;
        $content->content = $data['content'] ?? null;
        $content->slug = $this->slugService->generateUniqueSlug($data['title'] ?? '');
        $tags = explode('|', $data['tags']);
        foreach ($tags as $tagName) {
            $tag = $this->entityManager->getRepository(Tags::class)->findOneBy(['name' => $tagName]);
            if (!$tag) {
                $tag = new Tags();
                $tag->name = $tagName;
                $tag->color = $this->generateRandomColor();
                $this->entityManager->persist($tag);
            }
            $content->addTag($tag);
        }

        $this->entityManager->persist($content);

        $this->entityManager->flush();
    }

    private function downloadImage(string $url): string
    {
        $imageContent = file_get_contents($url);
        if ($imageContent === false) {
            throw new BadRequestHttpException('Failed to download image.');
        }

        $tempFile = tempnam(sys_get_temp_dir(), 'upload_');
        file_put_contents($tempFile, $imageContent);

        $uploadedFile = new UploadedFile($tempFile, basename($url), null, null, true);
        return $this->fileUploader->upload($uploadedFile);
    }

    private function generateRandomColor(): string
    {
        return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
    }
}