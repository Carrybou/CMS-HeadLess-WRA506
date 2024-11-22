<?php

namespace App\Tests\Units;

use App\Service\FileUploader;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class FileUploaderTest extends TestCase
{
    public function testValidateFileThrowsExceptionForLargeFile()
    {
        $fileUploader = new FileUploader('/path/to/upload/dir');
        $largeFile = $this->createMock(UploadedFile::class);
        $largeFile->method('getSize')->willReturn(3 * 1024 * 1024); // 3MB
        $largeFile->method('getMimeType')->willReturn('image/jpeg');

        $this->expectException(BadRequestHttpException::class);
        $this->expectExceptionMessage('File size exceeds the maximum limit of 2MB.');

        $reflection = new \ReflectionClass($fileUploader);
        $method = $reflection->getMethod('validateFile');
        $method->invoke($fileUploader, $largeFile);
    }
    public function testSlugify()
    {
        $fileUploader = new FileUploader('/path/to/upload/dir');

        $reflection = new \ReflectionClass($fileUploader);
        $method = $reflection->getMethod('slugify');
        $this->assertEquals('sample-title', $method->invoke($fileUploader, 'Sample Title'));
        $this->assertEquals('another-sample-title-', $method->invoke($fileUploader, 'Another Sample Title!'));
        $this->assertEquals('title-with-numbers-123', $method->invoke($fileUploader, 'Title with numbers 123'));
        $this->assertEquals('title-with-accent-', $method->invoke($fileUploader, 'Title with accent é'));
    }
}
