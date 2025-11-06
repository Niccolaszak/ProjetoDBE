<?php
// app/Services/ReportService.php
namespace App\Services;

use App\Domain\Reports\ReportFactory;
use App\Domain\Reports\ReportInterface;
use App\Models\Livro;

class ReportService
{
    public function __construct(protected ReportFactory $reportFactory)
    {
    }

    /**
     * @param string $type
     * @return array
     */
    public function generateLivroReport(string $type): array
    {
        
        $sourceData = Livro::with('genero')->get()->toArray();

        $reportGenerator = $this->reportFactory->createReport($type);

        return [
            'generator' => $reportGenerator,
            'data' => $sourceData,
        ];
    }
}