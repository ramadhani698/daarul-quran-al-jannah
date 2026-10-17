<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProgramDonasiRequest extends FormRequest
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
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            'kategori_donasi_id' => ['required', 'exists:kategori_donasis,id'],
            'nama_program' => ['required', 'string', 'max:150'],
            'deskripsi' => ['required', 'string'],
            'gambar' => [
                $isUpdate ? 'nullable' : 'required', // wajib pas create, opsional pas update (boleh keep gambar lama)
                'image',
                'mimes:jpg,jpeg,png',
                'mimetypes:image/jpeg,image/png',
                'max:2048',
            ],
            'target_donasi' => ['nullable', 'numeric', 'min:1', 'max:1000000000000'],
            'tanggal_mulai' => ['required', 'date'],
            'tanggal_selesai' => ['nullable', 'date', 'after_or_equal:tanggal_mulai'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'kategori_donasi_id.required' => 'Kategori wajib dipilih.',
            'kategori_donasi_id.exists' => 'Kategori tidak ditemukan.',
            'nama_program.required' => 'Nama program wajib diisi.',
            'gambar.required' => 'Gambar program wajib diunggah.',
            'gambar.image' => 'File harus berupa gambar.',
            'target_donasi.min' => 'Target donasi minimal Rp 1. Kosongkan kalau tanpa target.',
            'target_donasi.max' => 'Target donasi terlalu besar.',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai tidak boleh sebelum tanggal mulai.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $target = preg_replace('/[^0-9]/', '', (string) $this->target_donasi);

        $this->merge([
            'is_active' => $this->boolean('is_active'),
            'target_donasi' => $target !== '' ? $target : null,
        ]);
    }
}
