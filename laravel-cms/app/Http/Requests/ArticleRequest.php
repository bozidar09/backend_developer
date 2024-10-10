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
        return [
            'title' => ['required', 'string'],
            'image' => ['nullable', 'image'],
            'body' => ['required', 'string'],
            'featured' => ['nullable', 'integer', 'gte:0', 'lte:1'],
            'category_id' => ['required', 'integer', 'gt:0', 'exists:categories,id'],
            'tags' => ['nullable', 'integer', 'gt:0', 'exists:tags,id'],
        ];
    }
}
