<?php
// app/Http/Controllers/ReportController.php
namespace App\Http\Controllers;

use App\Services\ReportService;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;

class ReportController extends Controller
{
    public function __construct(protected ReportService $reportService)
    {
    }

    /**
     * @param string $type
     */
    public function downloadLivros(string $type)
    {
        try {
            
            $result = $this->reportService->generateLivroReport($type);

            $reportGenerator = $result['generator'];
            $sourceData      = $result['data'];
            $fileType        = $reportGenerator->getFileType();

            $content = $reportGenerator->generate($sourceData);

            $fileName = "relatorio-livros.{$fileType}";
            $mimeType = ($fileType === 'pdf') ? 'application/pdf' : 'text/csv';

            // Retorna a resposta como um download
            return response($content, 200, [
                'Content-Type' => $mimeType,
                'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
            ]);

        } catch (InvalidArgumentException $e) {
            return response("Erro: " . $e->getMessage(), 400);
        }
    }
}