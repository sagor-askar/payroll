<?php

namespace App\Http\Requests;

use App\Models\Employee;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreEmployeeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('employee_create');
    }

    public function rules()
    {
        return [
            'department_id' => [
                'required',
               
            ],
            'designation_id' => [
                'required',
              
            ],
            'first_name' => [
               
                'required',
            ],
            'last_name' => [
               
                'required',
            ],
            'father_name' => [
               
                'required',
            ],
            'mother_name' => [
               
                'required',
            ],
            'address' => [
                
                'required',
            ],
            'email' => [
              
                'required',
            ],
            'contact_no' => [
                
                'nullable',
            ],
            'gender' => [
                'required',
            ],
            'joining_date' => [
                'required',
              
            ],
            // 'certificates' => [
            //     'array',
            //     'required',
            // ],
            // 'certificates.*' => [
            //     'required',
            // ],
        ];
    }
}
