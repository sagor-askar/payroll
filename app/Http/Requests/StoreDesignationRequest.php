<?php

namespace App\Http\Requests;

use App\Models\Designation;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreDesignationRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('designation_create');
    }

    public function rules()
    {
        return [
            // 'department_id' => [
            //     'required',
            //     'integer',
            // ],
            'designation_name' => [
                'string',
                'required',
            ],
        ];
    }
}
