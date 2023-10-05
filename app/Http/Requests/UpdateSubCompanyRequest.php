<?php

namespace App\Http\Requests;

use App\Models\SubCompany;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateSubCompanyRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('sub_company_edit');
    }

    public function rules()
    {
        return [
            'sub_company_name' => [
                'string',
                'required',
            ],
            'sub_company_address' => [
                'string',
                'required',
            ],
            'contact_no' => [
                'string',
                'nullable',
            ],
        ];
    }
}
