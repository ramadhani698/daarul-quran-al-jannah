<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class KategoriDonasiRequest extends FormRequest
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
            'nama' => [
                'required',
                'string',
                'max:100',
                Rule::unique('kategori_donasis', 'nama')->ignore($this->route('kategori_donasi')),
            ],
            'icon' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,svg',
                'max:512',
            ],
            'is_active' => ['nullable', 'boolean'],
            'urutan' => ['nullable', 'integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama kategori wajib diisi.',
            'nama.unique' => 'Kategori dengan nama ini sudah ada.',
            'icon.image' => 'File harus berupa gambar.',
            'icon.mimes' => 'Format icon harus jpg, jpeg, png, atau svg.',
            'icon.max' => 'Ukuran icon maksimal 512KB.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->boolean('is_active'),
            'urutan' => $this->urutan ?? 0,
        ]);
    }
}
