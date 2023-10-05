<?php

namespace App\Http\Requests;

use App\Models\WeeklyHoliday;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreWeeklyHolidayRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('weekly_holiday_create');
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
            'weeklyleave' => [
                'string',
                'required',
            ],
        ];
    }
}
