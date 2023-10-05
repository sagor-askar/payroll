<?php

namespace App\Http\Requests;

use App\Models\Company;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCompanyRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('company_edit');
    }

    public function rules()
    {
        return [
            'comp_name' => [
                'string',
                'required',
            ],
            'comp_address' => [
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
