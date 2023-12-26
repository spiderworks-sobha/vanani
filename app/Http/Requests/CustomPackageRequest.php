<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomPackageRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'accommodation_id' => 'required|integer|exists:accommodations,id',
            'name' => 'required|max:250',
            'phone_number' => 'required|max:20',
            'email' => 'nullable|email',
            'checkin_date' => 'required|date',
            'checkout_date' => 'required|date',
            'no_of_adults' => 'required|integer'
        ];
    }
}
