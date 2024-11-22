<?php declare(strict_types=1);

namespace App\ApiResource\Action;

use App\ApiResource\CsvImport;
use App\Service\CsvImporter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

#[AsController]
class CsvImportAction
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private CsvImporter $csvImporter,
        private CsvImport $CsvImport,
    ) {
    }

    public function __invoke(Request $request)
    {
        $file = $request->files->get('file');

        if (!$file || 'csv' !== $file->getClientOriginalExtension()) {
            throw new BadRequestHttpException('Invalid file uploaded. Please upload a CSV file.');
        }

        $this->csvImporter->import($file->getPathname());
        $Import = new CsvImport();
        $Import->isSuccess = true;

        return $Import;
    }
}
