<?php

namespace App\Http\Requests;

use App\Models\WeeklyHoliday;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyWeeklyHolidayRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('weekly_holiday_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:weekly_holidays,id',
        ];
    }
}
