<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if ($this->isMethod('post') || $this->isMethod('put')) {
            return [
                'title' => ['required', 'string'],
                'body' => ['required', 'string'],
                'image' => ['nullable', 'image'],
                'featured' => ['nullable', 'boolean'],
                'category_id' => ['required', 'integer', 'gt:0', 'exists:categories,id'],
                'tags' => ['nullable', 'exists:tags,id'],
            ];
        }

        if ($this->isMethod('get')) {
            return [
                'users' => ['nullable', 'exists:users,id'],
                'categories' => ['nullable', 'exists:categories,id'],
                'tags' => ['nullable', 'exists:tags,id'],
            ];
        }
    }

    public function messages()
    {
        return [
            'featured.boolean' => 'The featured field must be 1 or 0.',
            'tags.exists' => 'This tag does not exist.',
        ];
    }
}
