<?php

namespace App\Http\Requests;

use App\Models\LeaveApplication;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyLeaveApplicationRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('leave_application_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:leave_applications,id',
        ];
    }
}
