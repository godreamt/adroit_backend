<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
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
            'id' => 'nullable|exists:customer_reviews,id',
            'stars' => 'nullable|numberic|in:0,1,2,3,4,5',
            'name' => 'required|max:75',
            'subTitle' => 'nullable|max:80',
            'review' => 'required|max:150'
        ];
    }
}
