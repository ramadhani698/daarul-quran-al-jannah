<?php

namespace App\Exports\Sheets;

use App\Models\ProgramDonasi;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;

class DetailDonasiSheet extends DefaultValueBinder implements FromArray, WithCustomValueBinder, WithHeadings, WithMapping, WithTitle
{
    public function __construct(protected ProgramDonasi $program)
    {
    }

    public function array(): array
    {
        return $this->program->donasis()->latest()->get()->all();
    }

    public function map($donasi): array
    {
        return [
            $donasi->kode_donasi,
            $donasi->nama_donatur,
            $donasi->is_anonim ? 'Ya' : 'Tidak',
            $donasi->no_hp ?? '-',
            number_format($donasi->nominal, 0, ',', '.'),
            match ($donasi->status) {
                'verified' => 'Terverifikasi',
                'rejected' => 'Ditolak',
                default => 'Pending',
            },
            $donasi->catatan_admin ?? '-',
            $donasi->bukti_transfer,
            $donasi->pesan_doa ?? '-',
            $donasi->created_at->format('d-m-Y H:i'),
        ];
    }

    public function headings(): array
    {
        return [
            'Kode Donasi', 'Nama Donatur', 'Tampil Anonim?', 'No. HP',
            'Nominal (Rp)', 'Status', 'Catatan Admin', 'File Bukti Transfer',
            'Pesan/Doa', 'Tanggal Donasi',
        ];
    }

    public function title(): string
    {
        return 'Detail Donasi';
    }

    public function bindValue(Cell $cell, mixed $value): bool
    {
        $cell->setValueExplicit((string) $value, DataType::TYPE_STRING);

        return true;
    }
}