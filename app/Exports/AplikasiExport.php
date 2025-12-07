<?php

namespace App\Exports;

use App\Models\Master\MasterAplikasi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AplikasiExport implements FromCollection, WithHeadings
{
    // constructor
    public function __construct() {}
    public function collection()
    {
        $query = MasterAplikasi::get();
        return $query;
    }

    public function headings(): array
    {
        return [
            'ID',
            'NAMA',
            'KETERANGAN'
        ];
    }
}
