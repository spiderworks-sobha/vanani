<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class Review extends FormRequest
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
        $file_size =  (int)ini_get("upload_max_filesize")*1024;
        $rules = [
            "name" => 'required|max:250',
            "review_type" => 'required',
            "text_review" => "required_if:review_type,Text",
        ];
        if(empty($this->input('video_exist')))
            $rules["video_review"] = "required_if:review_type,Video|max:".$file_size;

        return $rules;
    }
}
