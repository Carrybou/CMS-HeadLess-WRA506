<?php declare(strict_types=1);

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use function in_array;
use const PATHINFO_FILENAME;

class FileUploader
{
    public function __construct(
        private string $uploadDir,
    ) {
    }

    public function upload(UploadedFile $file): string
    {
        $this->validateFile($file);

        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugify($originalFilename);
        $newFilename = $safeFilename . '-' . uniqid() . '.' . $file->getClientOriginalExtension();

        $file->move($this->uploadDir, $newFilename);

        return $newFilename;
    }

    private function validateFile(UploadedFile $file): void
    {
        $maxSize = 2 * 1024 * 1024; // 2MB
        $allowedMimeTypes = ['image/jpeg', 'image/png'];

        if ($file->getSize() > $maxSize) {
            throw new BadRequestHttpException('File size exceeds the maximum limit of 2MB.');
        }

        if (!in_array($file->getMimeType(), $allowedMimeTypes)) {
            throw new BadRequestHttpException('Invalid file type. Only JPG and PNG are allowed.');
        }
    }

    private function slugify(string $text): string
    {
        return preg_replace('/[^a-z0-9]+/', '-', strtolower(trim(strip_tags($text))));
    }
}
