<?php

namespace App\Http\Requests;

use App\Models\SalaryAllowance;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroySalaryAllowanceRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('salary_allowance_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:salary_allowances,id',
        ];
    }
}
