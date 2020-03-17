<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'id' => 'nullable|exists:users,id', 
            'firstName' => 'required|string|max:75',
            'lastName' => 'nullable|string|max:75',
            'email' => 'required|email|unique:users,email,'.$this->id,',id',
            'mobileNumber' => 'required|numeric|unique:users,mobileNumber,'.$this->id,',id|regex:/^(\+?)(\d{2,4})(\s?)(\-?)((\(0\))?)(\s?)(\d{2})(\s?)(\-?)(\d{3})(\s?)(\-?)(\d{2})(\s?)(\-?)(\d{2})$/',
            'address' => 'nullable|string|max:300',
            'isActive' => 'required|in:yes,no',
            'roles' => 'required|in:admin,country_head,state_head,regional_head,sales_executive,vendors|check_address:'.$this->country_id.",".$this->state_id.",".$this->region_id.",".$this->area_id,//."|check_salary:".$this->monthlySalary.",".$this->salesTarget.",".$this->collectionTarget,
            'monthlySalary' => 'nullable|numeric|between:0,500000',
            'salesTarget' => 'nullable|numeric|between:0,500000',
            'collectionTarget' => 'nullable|numeric|between:0,500000',
            'password' => 'nullable|string:min:8',
            'country_id' => 'nullable|exists:countries,id',
            'state_id' => 'nullable|exists:states,id',
            'region_id' => 'nullable|exists:regions,id',
            'area_id' => 'nullable|exists:areas,id',
            'fatherName' => 'nullable|string|max:80',
            'motherName' => 'nullable|string|max:80',
            'alternativeMobileNumber' => 'nullable|numeric|regex:/^(\+?)(\d{2,4})(\s?)(\-?)((\(0\))?)(\s?)(\d{2})(\s?)(\-?)(\d{3})(\s?)(\-?)(\d{2})(\s?)(\-?)(\d{2})$/',
            'alternativeEmail' => 'nullable|email',
            'alternativeAddress' => 'nullable|string|max:300',
            'maritalStatus' => 'nullable|in:married,unmarried',
            'panNumber' => 'nullable|string|max:100',
            'adharNumber' => 'nullable|string|max:100',
            'drivingLicence' => 'nullable|string|max:100',
            'dateOfBirth' => 'nullable|date',
        ];
    }
}
