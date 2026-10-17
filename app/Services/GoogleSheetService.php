<?php

namespace App\Services;

use Google\Client as GoogleClient;
use Google\Service\Sheets as GoogleSheets;
use Illuminate\Support\Facades\Cache;

class GoogleSheetService
{
    protected GoogleSheets $service;
    protected string $spreadsheetId;
    protected string $range;

    public function __construct()
    {
        $client = new GoogleClient();
        $client->setApplicationName('Daarul Quran Al-Jannah - Pendaftaran');
        $client->setScopes([GoogleSheets::SPREADSHEETS_READONLY]);
        $client->setAuthConfig(base_path(config('services.google_sheets.credentials_path')));

        $this->service = new GoogleSheets($client);
        $this->spreadsheetId = config('services.google_sheets.spreadsheet_id');
        $this->range = config('services.google_sheets.range');
    }

    public function getRawData(): array
    {
        return Cache::remember('data-pendaftaran-sheet', now()->addMinutes(10), function () {
            $response = $this->service->spreadsheets_values->get($this->spreadsheetId, $this->range);

            return $response->getValues() ?? [];
        });
    }

    public function clearCache(): void
    {
        Cache::forget('data-pendaftaran-sheet');
    }

    /**
     * Data mentah utuh (semua kolom) - dipakai buat export
     */
    public function getAllRows(): array
    {
        $values = $this->getRawData();
        return count($values) > 1 ? array_slice($values, 1) : [];
    }

    public function getHeader(): array
    {
        $values = $this->getRawData();
        return $values[0] ?? [];
    }

    /**
     * Data yang udah dipetakan ke kolom tampilan (buat tabel admin)
     * Index kolom disesuaikan sama posisi di Google Form kamu
     */
    public function getPendaftarForTable(): array
    {
        $rows = $this->getAllRows();

        return array_map(function ($row, $index) {
            return [
                'no' => $index + 1,
                'tanggal_daftar' => $row[0] ?? '',
                'nama_lengkap' => $row[1] ?? '',
                'tanggal_lahir' => $row[6] ?? '',
                'provinsi' => $row[32] ?? '',
                'kabupaten' => $row[33] ?? '',
                'row_number' => $index + 2,
            ];
        }, $rows, array_keys($rows));
    }
}