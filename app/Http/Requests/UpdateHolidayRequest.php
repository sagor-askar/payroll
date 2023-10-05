<?php

namespace App\Http\Requests;

use App\Models\Holiday;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateHolidayRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('holiday_edit');
    }

    public function rules()
    {
        return [
            'department_id' => [
                'required',
                'integer',
            ],
            'company_id' => [
                'required',
                'integer',
            ],
            'holiday_name' => [
                'string',
                'required',
            ],
            'from_holiday' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'to_holiday' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'number_of_days' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
