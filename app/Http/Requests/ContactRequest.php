<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'id' => 'nullable|exists:contact_uses,id',
            'fullName' => 'required|max:75',
            'email' => 'required|email',
            'mobileNumber' => 'required|numeric|regex:/^[0-9]{10,12}$/',
            'reasonText' => 'required|max:150',
            'status' => 'required|in:new,processed,cancelled'
        ];
    }
}
