<?php declare(strict_types=1);

namespace App\ApiResource\Action;

use App\Service\CsvImporter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class CsvImportAction
{
    private CsvImporter $csvImporter;

    public function __construct(CsvImporter $csvImporter)
    {
        $this->csvImporter = $csvImporter;
    }

    public function __invoke(Request $request): Response
    {
        // Use the $csvImportService to import data from the CSV file
        $file = $request->files->get('file');
        if ($file) {
            $this->csvImporter->import($file->getPathname());
        }

        // Optionally, use the $entityManager for any database operations
        // $this->entityManager->persist($entity);
        // $this->entityManager->flush();

        return new Response('CSV import completed successfully.');
    }
}
