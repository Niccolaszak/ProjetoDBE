<?php
// app/Domain/Reports/ReportFactory.php
namespace App\Domain\Reports;

use App\Domain\Reports\ReportInterface;
use App\Domain\Reports\Implementations\LivroCsvReport;
use App\Domain\Reports\Implementations\LivroPdfReport;
use InvalidArgumentException;

class ReportFactory
{
    /**
     * @param string $type
     * @return ReportInterface
     * @throws InvalidArgumentException
     */
    public function createReport(string $type): ReportInterface
    {

        return match (strtolower($type)) {
            'pdf' => new LivroPdfReport(),
            'csv' => new LivroCsvReport(),
            default => throw new InvalidArgumentException("Tipo de relatório '{$type}' não suportado."),
        };
    }
}