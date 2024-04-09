<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCarRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'model'         => 'required',
            'price'         => 'required|numeric|min:100000',
            'colors'        => 'required|string|max:255',
            'gear_type'     => 'required|string|max:255',
            'year'          => 'required|numeric|min:4',
        ];
    }
}