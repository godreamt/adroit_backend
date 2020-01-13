<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MonthlyTargetRequest extends FormRequest
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
            'id' => 'nullable|exists:user_monthly_targets,id',
            'month' => 'required|numeric|between:1,12',
            'year' => 'required|numeric|between:2017,2021',
            'salesTarget' => 'required|numeric|between:0,5000000',
            'collectionTarget' => 'required|numeric|between:0,5000000',
            'user_id' => 'required|exists:users,id'
        ];
    }
}
