<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpenseAddRequest extends FormRequest
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
            'id' => 'nullable|exists:expense_trackers,id',
            'title'=> 'required',
            'description' => 'nullable',
            'expenseAmount' => 'required|numeric|between:0,100000',
            'documentImage' => 'required',
            'user_id' => 'nullable|exists:users,id'
        ];
    }
}
