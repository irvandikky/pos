<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'image' => ['nullable', 'image', 'max:1024', 'mimes:png,jpg,jpeg,webp'],
            'name' => ['required', 'max:255', 'string'],
            'description' => ['nullable', 'max:255', 'string'],
            'price' => ['required', 'numeric'],
            'stock' => ['required', 'numeric'],
            'status' => ['required', 'boolean'],
            'categories' => ['required', 'array'],
            'categories.*.value' => ['required', Rule::in(Category::select('id')->pluck('id')->toArray()) ]
        ];
    }
}
