<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CustomerStoreRequest extends FormRequest
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
                'unique:customers,email',
                'max:255',
                'string',
            ],
            'phone' => [
                'required',
                'unique:customers,phone',
                'max:255',
                'string',
            ],
            'address' => ['required', 'max:255', 'string'],
            'city' => ['required', 'max:100', 'string'],
            'zip' => ['required', 'max:10', 'string'],
        ];
    }
}
