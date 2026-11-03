<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CarouselRequest extends FormRequest
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
        $isUpdate = $this->route('carousel') !== null;

        return [
            'image' => $isUpdate
                ? 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048'
                : 'required|image|mimes:jpeg,jpg,png,webp|max:2048',

            'order' => 'required|integer',
            'is_active' => 'nullable|boolean',
        ];
    }
}
