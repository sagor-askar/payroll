<?php

namespace App\Http\Requests;

use App\Models\SalaryAllowance;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateSalaryAllowanceRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('salary_allowance_edit');
    }

    public function rules()
    {
        return [
            'allowance_name' => [
                'required',
            ],
            'percentage' => [
                'required',
            ],
        ];
    }
}
