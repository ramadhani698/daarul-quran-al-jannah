<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CarouselDonasiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // akses admin udah dijaga middleware di route
    }

    protected function prepareForValidation(): void
    {
        // checkbox yg nggak dicentang nggak ngirim apa-apa
        $this->merge(['is_aktif' => $this->boolean('is_aktif')]);
    }

    public function rules(): array
    {
        $isUpdate = $this->isMethod('put') || $this->isMethod('patch');

        return [
            'judul'             => ['nullable', 'string', 'max:100'],
            'gambar'            => [$isUpdate ? 'nullable' : 'required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10840'],
            'program_donasi_id' => ['nullable', 'integer', Rule::exists('program_donasis', 'id')->whereNull('deleted_at')],
            'urutan'            => ['nullable', 'integer', 'min:0'],
            'is_aktif'          => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'gambar.required' => 'Gambar banner wajib diupload.',
            'gambar.image'    => 'File harus berupa gambar.',
            'gambar.mimes'    => 'Format gambar harus jpg, jpeg, png, atau webp.',
            'gambar.max'      => 'Ukuran gambar maksimal 10 MB.',
            'program_donasi_id.exists' => 'Program yang dipilih tidak valid atau sudah diarsip.',
        ];
    }
}