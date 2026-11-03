<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VerifikasiDonasiRequest extends FormRequest
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
            'status' => ['required', Rule::in(['verified', 'rejected'])],
            'status_awal' => ['required', Rule::in(['pending', 'verified', 'rejected'])],
            'catatan_admin' => [
                Rule::requiredIf(fn () => $this->status === 'rejected'),
                'nullable',
                'string',
                'max:500',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => 'Status verifikasi wajib dipilih.',
            'status_awal.required' => 'Halaman sudah kedaluwarsa, silakan buka ulang detail donasi.',
            'status.in' => 'Status tidak valid.',
            'catatan_admin.required_if' => 'Catatan wajib diisi jika donasi ditolak.',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $donasi = $this->route('donasi');
            if ($this->status === 'verified' && empty($donasi->bukti_transfer)) {
                $validator->errors()->add('status', 'Donasi tidak dapat diverifikasi karena donatur belum mengunggah bukti transfer.');
            }
        });
    }
}
