<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'content' => 'required',
            'published_at' => 'date|required',
            'is_published' => 'boolean|required',
            'files.*' => 'mimes:jpg,png,pdf,docx'
        ];
    }
}
