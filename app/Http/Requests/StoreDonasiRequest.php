<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDonasiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'program_donasi_id' => [
                'required',
                Rule::exists('program_donasis', 'id')->where(fn ($q) => $q->where('is_active', true)),
            ],
            'nama_donatur' => ['required', 'string', 'max:100'],
            'no_hp' => ['nullable', 'string', 'max:20', 'regex:/^[0-9+\-\s]+$/'],
            'is_anonim' => ['nullable', 'boolean'],
            'nominal' => ['required', 'numeric', 'min:1000', 'max:1000000000'],
            'metode_pembayaran' => ['required', 'in:bank,qris'],
            // NULLABLE — donatur boleh submit dulu, transfer + upload bukti belakangan
            // lewat halaman status (lihat DonasiController@resubmit).
            'bukti_transfer' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'mimetypes:image/jpeg,image/png,application/pdf',
                'max:2048',
            ],
            'pesan_doa' => ['nullable', 'string', 'max:500'],
            'website' => ['prohibited'],
        ];
    }

    public function messages(): array
    {
        return [
            'program_donasi_id.required' => 'Program donasi tidak valid.',
            'program_donasi_id.exists' => 'Program donasi tidak ditemukan atau sudah tidak aktif.',
            'nama_donatur.required' => 'Nama wajib diisi.',
            'no_hp.regex' => 'Format nomor HP tidak valid.',
            'nominal.required' => 'Nominal donasi wajib diisi.',
            'nominal.min' => 'Minimal donasi adalah Rp1.000.',
            'nominal.max' => 'Nominal donasi tidak wajar, silakan hubungi admin untuk donasi besar.',
            'bukti_transfer.mimes' => 'Bukti transfer harus berupa file JPG, PNG, atau PDF.',
            'bukti_transfer.mimetypes' => 'Format file bukti transfer tidak valid.',
            'bukti_transfer.max' => 'Ukuran file bukti transfer maksimal 2MB.',
            'pesan_doa.max' => 'Pesan/doa maksimal 500 karakter.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_anonim' => $this->boolean('is_anonim'),
            // Bersihin format nominal kalau dikirim dengan titik/koma ribuan dari frontend, misal "500.000" -> "500000"
            'nominal' => $this->nominal ? preg_replace('/[^0-9]/', '', $this->nominal) : null,
        ]);
    }
}