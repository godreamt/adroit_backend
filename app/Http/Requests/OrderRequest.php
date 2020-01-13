<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'discountAmount' => 'nullable|numeric|between:1,500000',
            'deliveryAddress' => 'nullable',
            'comments' => 'nullable',
            'vendor_id' => 'required|exists:users,id',
            'items' => 'required',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|between:1,500000'
        ];
    }
}
