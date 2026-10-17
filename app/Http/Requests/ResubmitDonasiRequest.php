<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ResubmitDonasiRequest extends FormRequest
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
            'bukti_transfer' => [
                'required',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'mimetypes:image/jpeg,image/png,application/pdf',
                'max:10840',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'bukti_transfer.required' => 'Bukti transfer baru wajib diunggah.',
            'bukti_transfer.mimes' => 'Bukti transfer harus berupa file JPG, PNG, atau PDF.',
            'bukti_transfer.mimetypes' => 'Format file bukti transfer tidak valid.',
            'bukti_transfer.max' => 'Ukuran file bukti transfer maksimal 2MB.',
        ];
    }
}
