<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyWeeklyHolidayRequest;
use App\Http\Requests\StoreWeeklyHolidayRequest;
use App\Http\Requests\UpdateWeeklyHolidayRequest;
use App\Models\Company;
use App\Models\Department;
use App\Models\User;
use App\Models\WeeklyHoliday;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class WeeklyHolidayController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('weekly_holiday_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $weeklyHolidays = WeeklyHoliday::with(['department', 'company', 'created_by'])->paginate(20);

        return view('admin.weeklyHolidays.index', compact('weeklyHolidays'));
    }

    public function create()
    {
        abort_if(Gate::denies('weekly_holiday_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $companyID = User::find(Auth::user()->id);
        $companies = Company::whereUserId($companyID->company_id)->first();
        $departments = Department::whereCompanyId($companies->id)->pluck('department_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.weeklyHolidays.create', compact('companies', 'departments'));
    }

    public function store(StoreWeeklyHolidayRequest $request)
    {
        $weeklyHoliday = WeeklyHoliday::create($request->all());

        return redirect()->route('admin.weekly-holidays.index')->with('message','Holiday setup successfully');
    }

    public function edit(WeeklyHoliday $weeklyHoliday)
    {
        abort_if(Gate::denies('weekly_holiday_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $companyID = User::find(Auth::user()->id);
        $companies = Company::whereUserId($companyID->company_id)->first();
        $departments = Department::whereCompanyId($companies->id)->pluck('department_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $weeklyHoliday->load('department', 'company', 'created_by');

        return view('admin.weeklyHolidays.edit', compact('companies', 'departments', 'weeklyHoliday'));
    }

    public function update(UpdateWeeklyHolidayRequest $request, WeeklyHoliday $weeklyHoliday)
    {
        $weeklyHoliday->update($request->all());

        return redirect()->route('admin.weekly-holidays.index')->with('message','Updated successfully');
    }

    public function show(WeeklyHoliday $weeklyHoliday)
    {
        abort_if(Gate::denies('weekly_holiday_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $weeklyHoliday->load('department', 'company', 'created_by');

        return view('admin.weeklyHolidays.show', compact('weeklyHoliday'));
    }

    public function destroy(WeeklyHoliday $weeklyHoliday)
    {
        abort_if(Gate::denies('weekly_holiday_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $weeklyHoliday->delete();

        return back();
    }

    public function massDestroy(MassDestroyWeeklyHolidayRequest $request)
    {
        WeeklyHoliday::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
