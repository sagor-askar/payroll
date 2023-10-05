<?php

namespace App\Http\Requests;

use App\Models\SubCompany;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroySubCompanyRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('sub_company_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:sub_companies,id',
        ];
    }
}
