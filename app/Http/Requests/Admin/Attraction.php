<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class Attraction extends FormRequest
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
        $ignoreId = ($this->input('id'))?decrypt($this->input('id')):NULL;
        return [
            'id' => 'sometimes',
            'name' => "required|max:250|unique:attractions,name,{$ignoreId},id,deleted_at,NULL",
        ];
    }
}
