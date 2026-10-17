<?php

namespace App\Exports\Sheets;

use App\Models\ProgramDonasi;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;

class RingkasanProgramSheet extends DefaultValueBinder implements FromArray, WithCustomValueBinder, WithHeadings, WithStrictNullComparison, WithTitle
{
    public function __construct(protected ProgramDonasi $program)
    {
    }

    public function array(): array
    {
        $program = $this->program;

        $totalVerified = $program->donasisVerified()->sum('nominal');
        $jumlahDonatur = $program->donasisVerified()->count();
        $pendingCount = $program->donasis()->menungguVerifikasi()->count();
        $rejectedCount = $program->donasis()->where('status', 'rejected')->count();

        return [
            [
                $program->nama_program,
                $program->kategori->nama,
                $program->tanggal_mulai->format('d-m-Y'),
                $program->tanggal_selesai ? $program->tanggal_selesai->format('d-m-Y') : 'Tanpa batas',
                $program->target_donasi ? number_format($program->target_donasi, 0, ',', '.') : 'Tanpa target',
                number_format($totalVerified, 0, ',', '.'),
                $jumlahDonatur,
                $pendingCount,
                $rejectedCount,
                now()->format('d-m-Y H:i'),
                auth()->user()->name ?? 'Admin',
            ],
        ];
    }

    public function headings(): array
    {
        return [
            'Nama Program',
            'Kategori',
            'Tanggal Mulai',
            'Tanggal Selesai',
            'Target Donasi (Rp)',
            'Total Terkumpul (Rp)',
            'Jumlah Donatur',
            'Donasi Pending',
            'Donasi Ditolak',
            'Tanggal Rekap',
            'Diunduh Oleh',
        ];
    }

    public function title(): string
    {
        return 'Ringkasan';
    }

    public function bindValue(Cell $cell, mixed $value): bool
    {
        $cell->setValueExplicit((string) $value, DataType::TYPE_STRING);

        return true;
    }
}