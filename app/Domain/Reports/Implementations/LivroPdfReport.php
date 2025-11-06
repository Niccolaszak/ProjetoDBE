<?php
// app/Domain/Reports/Implementations/LivroPdfReport.php
namespace App\Domain\Reports\Implementations;

use App\Domain\Reports\ReportInterface;
use Barryvdh\DomPDF\Facade\Pdf;

class LivroPdfReport implements ReportInterface
{
    /**
     * @param array $data
     * @return string
     */
    public function generate(array $data): string
    {
    
        $pdf = Pdf::loadView('reports.livros-pdf', ['livros' => $data]);

        return $pdf->output();
    }

    public function getFileType(): string
    {
        return 'pdf';
    }
}