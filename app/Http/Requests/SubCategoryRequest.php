<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubCategoryRequest extends FormRequest
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
            'id' => 'nullable|exists:sub_categories,id',
            'title' => 'required|max:75',
            'description' => 'required',
            'shortDescription' => 'required|max:600',
            'featuredImage' => 'nullable',
            'category_id' => 'required|exists:categories,id'
        ];
    }
}
