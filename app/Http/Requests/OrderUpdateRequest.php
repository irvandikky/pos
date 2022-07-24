<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderUpdateRequest extends FormRequest
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
            'customer_id' => ['required', 'exists:customers,id'],
            'status' => ['required', 'in:Cancel,Pending,Complete'],
            'products' => ['required', 'array'],
            'products.*' => ['required', 'array'],
            'products.*.id' => ['required', 'exists:products,id'],
            'products.*.qty' => ['required', 'numeric', 'min:0'],
        ];
    }
}
