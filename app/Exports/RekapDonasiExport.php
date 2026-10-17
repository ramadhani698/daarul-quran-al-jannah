<?php

namespace App\Exports;

use App\Exports\Sheets\DetailDonasiSheet;
use App\Exports\Sheets\RingkasanProgramSheet;
use App\Models\ProgramDonasi;
use Maatwebsite\Excel\Concerns\Export;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class RekapDonasiExport implements Export, WithMultipleSheets
{
    public function __construct(protected ProgramDonasi $program)
    {
    }

    public function sheets(): array
    {
        return [
            'Ringkasan' => new RingkasanProgramSheet($this->program),
            'Detail Donasi' => new DetailDonasiSheet($this->program),
        ];
    }
}