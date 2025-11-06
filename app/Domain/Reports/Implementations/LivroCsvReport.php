<?php
// app/Domain/Reports/Implementations/LivroCsvReport.php
namespace App\Domain\Reports\Implementations;

use App\Domain\Reports\ReportInterface;

/**
 * Relatório de Livros em CSV.
 */
class LivroCsvReport implements ReportInterface
{
    /**
     * @param array $data
     * @return string
     */
    public function generate(array $data): string
    {
        $output = "ID,Titulo,Autor\n";

        foreach ($data as $livro) {
            $livro = (array) $livro;
            $output .= "{$livro['id']},{$livro['titulo']},{$livro['autor']}\n";
        }

        return $output;
    }

    public function getFileType(): string
    {
        return 'csv';
    }
}