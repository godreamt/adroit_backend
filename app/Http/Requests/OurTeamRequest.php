<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OurTeamRequest extends FormRequest
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
            'id' => 'nullable|exists:our_teams,id',
            'fullName' => 'required|max:100',
            'designation' => 'required|max:100',
            'shortDescription' => 'required|max:230',
            'profileImage' => 'nullable',
            'experience' => 'nullable|max:75',
            'priority' => 'required|numeric|between:1,9999'
        ];
    }
}
