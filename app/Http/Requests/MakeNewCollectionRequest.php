<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MakeNewCollectionRequest extends FormRequest
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
            'collectionAmount' => 'required|numeric|between:1000,5000000',
            'paymentMethod' => 'required|in:cash,cheque,demandDraft,neft,other',
            'relatedInfo' => 'nullable',
            'comments' => 'nullable',
            'order_id' => 'required|exists:orders,id'
        ];
    }
}
