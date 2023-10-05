<?php

namespace App\Http\Requests;

use App\Models\LeaveType;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateLeaveTypeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('leave_type_edit');
    }

    public function rules()
    {
        return [
            'sub_company_id' => [
                'required',
                'integer',
            ],
            'company_id' => [
                'required',
                'integer',
            ],
            'leave_name' => [
                'string',
                'required',
            ],
            'no_of_days' => [
                'required',
                'integer',
            ],
        ];
    }
}
