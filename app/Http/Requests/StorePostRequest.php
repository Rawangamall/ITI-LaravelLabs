<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class StorePostRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $post = $this->route('post');

        return [
            "title" => "required|min:3",
            // Rule::unique('posts')->ignore($post->id),
            "description" => "required|min:10",
            'image' => 'required|mimes:jpg,png',
        ];
    }
    public function messages(): array
    {
        return ["title.required" => 'The title is required (custom msg)',
        "title.unique" => 'The title must be unique (custom msg)',
        "title.min" => 'The title is 3 char min (custom msg)',
        "description.required" => 'The description is required (custom msg)',
        "description.min" => 'The description is 10 char min (custom msg)'
    ];
    }
}
