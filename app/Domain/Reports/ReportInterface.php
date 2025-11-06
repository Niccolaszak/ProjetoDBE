<?php
// app/Domain/Reports/ReportInterface.php
namespace App\Domain\Reports;

interface ReportInterface
{
    public function generate(array $data): string;

    public function getFileType(): string;
}