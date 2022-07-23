<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CustomerUpdateRequest extends FormRequest
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
            'name' => ['required', 'max:255', 'string'],
            'email' => [
                'required',
                Rule::unique('customers', 'email')->ignore($this->customer),
                'max:255',
                'string',
            ],
            'phone' => [
                'required',
                Rule::unique('customers', 'phone')->ignore($this->customer),
                'max:255',
                'string',
            ],
            'address' => ['required', 'max:255', 'json'],
        ];
    }
}
