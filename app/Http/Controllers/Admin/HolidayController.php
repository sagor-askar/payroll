<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyHolidayRequest;
use App\Http\Requests\StoreHolidayRequest;
use App\Http\Requests\UpdateHolidayRequest;
use App\Models\Company;
use App\Models\Department;
use App\Models\Holiday;
use App\Models\User;
use App\Notifications\UsersNotification;
use Gate;
use Illuminate\Http\Request;
use Notification;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class HolidayController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('holiday_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $holidays = Holiday::with(['department', 'company', 'created_by'])->paginate(20);

        return view('admin.holidays.index', compact('holidays'));
    }

    public function create()
    {
        abort_if(Gate::denies('holiday_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $companyID = User::find(Auth::user()->id);
        $companies = Company::whereUserId($companyID->company_id)->first();
        $departments = Department::whereCompanyId($companies->id)->pluck('department_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.holidays.create', compact('companies', 'departments'));
    }

    public function store(StoreHolidayRequest $request)
    {
        $holiday = Holiday::create($request->all());
        Notification::send(User::all(), new UsersNotification($holiday));
        return redirect()->route('admin.holidays.index')->with('message','Holiday added successfully');
    }
    public function markasread($id)
    {
        if($id){
            Auth::user()->unreadNotifications->where('id',$id)->markAsRead();
        }
        return back();
    }

    public function edit(Holiday $holiday)
    {
        abort_if(Gate::denies('holiday_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $companyID = User::find(Auth::user()->id);
        $companies = Company::whereUserId($companyID->company_id)->first();
        $departments = Department::whereCompanyId($companies->id)->pluck('department_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $holiday->load('department', 'company', 'created_by');

        return view('admin.holidays.edit', compact('companies', 'departments', 'holiday'));
    }

    public function update(UpdateHolidayRequest $request, Holiday $holiday)
    {
        $holiday->update($request->all());

        return redirect()->route('admin.holidays.index')->with('message','Updated successfully');
    }

    public function show(Holiday $holiday)
    {
        abort_if(Gate::denies('holiday_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $holiday->load('department', 'company', 'created_by');

        return view('admin.holidays.show', compact('holiday'));
    }

    public function destroy(Holiday $holiday)
    {
        abort_if(Gate::denies('holiday_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $holiday->delete();

        return back();
    }

    public function massDestroy(MassDestroyHolidayRequest $request)
    {
        Holiday::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
