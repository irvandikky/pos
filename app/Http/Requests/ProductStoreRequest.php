<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
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
            'categories.*' => ['required', 'array'],
            'categories.*.value' => ['required', 'exists:categories,id' ]
        ];
    }
}
