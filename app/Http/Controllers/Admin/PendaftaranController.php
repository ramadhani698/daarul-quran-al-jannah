<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\GoogleSheetService;
use App\Exports\PendaftaranExport;
use Maatwebsite\Excel\Facades\Excel;

class PendaftaranController extends Controller
{
    public function index(GoogleSheetService $sheet)
    {
        $pendaftar = $sheet->getPendaftarForTable();
        $spreadsheetId = config('services.google_sheets.spreadsheet_id');

        return view('backend.pendaftaran.index', compact('pendaftar', 'spreadsheetId'));
    }

    public function export(GoogleSheetService $sheet)
    {
        $header = $sheet->getHeader();
        $rows = $sheet->getAllRows();

        return Excel::download(
            new PendaftaranExport($header, $rows),
            'data-pendaftaran-' . now()->format('Y-m-d') . '.xlsx'
        );
    }

    public function refresh(GoogleSheetService $sheet)
    {
        $sheet->clearCache();

        return redirect()->route('admin.pendaftaran.index')
            ->with('success', 'Data pendaftaran berhasil diperbarui.');
    }
}
