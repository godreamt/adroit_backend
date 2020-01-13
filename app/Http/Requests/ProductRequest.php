<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'id' => 'nullable|exists:products,id',
            'title' => 'required|max:75',
            'description' => 'required',
            'shortDescription' => 'required|max:1500',
            'featureInfo' => 'nullable|max:3000',
            'offerPrice' => 'required|numeric',
            'regularPrice' => 'required|numeric',
            'salesPoints' => 'required|numeric',
            'featuredImage' => 'nullable',
            'removeFromList' => 'required|in:yes,no',
            'bestSeller' => 'required|in:yes,no',
            'sub_category_id' => 'required|exists:sub_categories,id'
        ];
    }
}
