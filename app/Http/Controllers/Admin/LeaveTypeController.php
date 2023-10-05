<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyLeaveTypeRequest;
use App\Http\Requests\StoreLeaveTypeRequest;
use App\Http\Requests\UpdateLeaveTypeRequest;
use App\Models\Company;
use App\Models\Department;
use App\Models\Employee;
use App\Models\LeaveApplication;
use App\Models\LeaveType;
use App\Models\SubCompany;
use App\Models\User;
use Gate;
use Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Mail;

class LeaveTypeController extends Controller
{
    public function index()
    {

        abort_if(Gate::denies('leave_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $leaveTypes = LeaveType::with(['department', 'company', 'created_by'])->paginate(20);

        return view('admin.leaveTypes.index', compact('leaveTypes'));
    }

    public function create()
    {
        abort_if(Gate::denies('leave_type_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $companyID = User::find(Auth::user()->id);
        $companies = Company::whereUserId($companyID->company_id)->first();
        $sub_companies = SubCompany::where('company_id',$companies->id)->pluck('sub_company_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        return view('admin.leaveTypes.create', compact('companies', 'sub_companies'));
    }

    public function store(StoreLeaveTypeRequest $request)
    {



        $leaveType = LeaveType::create($request->all());

        return redirect()->route('admin.leave-types.index')->with('message', 'Leave type added successfully');
    }

    public function edit(LeaveType $leaveType)
    {
        abort_if(Gate::denies('leave_type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $companyID = User::find(Auth::user()->id);
        $companies = Company::whereUserId($companyID->company_id)->first();
        $sub_companies = SubCompany::where('company_id',$companies->id)->pluck('sub_company_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $leaveType->load('subcompany','department', 'company', 'created_by');

        return view('admin.leaveTypes.edit', compact('companies', 'sub_companies', 'leaveType'));
    }

    public function update(UpdateLeaveTypeRequest $request, LeaveType $leaveType)
    {
        $leaveType->update($request->all());

        return redirect()->route('admin.leave-types.index')->with('message', 'Leave type updated successfully');
    }

    public function show(LeaveType $leaveType)
    {
        abort_if(Gate::denies('leave_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $leaveType->load('department', 'company', 'created_by');

        return view('admin.leaveTypes.show', compact('leaveType'));
    }

    public function destroy(LeaveType $leaveType)
    {
        abort_if(Gate::denies('leave_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $leaveType->delete();

        return back();
    }

    public function massDestroy(MassDestroyLeaveTypeRequest $request)
    {
        LeaveType::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function getTotalLeaveEmployee(Request $request)
    {
        $data  = LeaveType::where('id',$request->id)->first();
        return response()->json($data);
    }

    public function getLeftLeaveEmployee(Request $request)
    {
        $role_title =auth()->user()->roles->first()->title;
        if ($role_title == 'Employee'){
            $employee_id =   Auth::user()->employee_id;
            $auth_company_id = Auth::user()->company_id;
            $total_paid_leavedays  = LeaveApplication::where('leave_type_id',$request->id)->where('employee_id',$employee_id)->where('company_id',$auth_company_id)->where('status',1)->get()->sum('no_of_days');
        }else{
            $employees = Employee::find($request->emp_id);
            $employee_id =   $employees->id;
            $department_id = $employees->department_id;
            $departments =Department::find($department_id);
            $company_id =   $departments->company_id;
            $total_paid_leavedays  = LeaveApplication::where('leave_type_id',$request->id)->where('employee_id',$employee_id)->where('company_id',$company_id)->where('department_id',$department_id)->where('status',1)->get()->sum('no_of_days');
        }
        $leavetypes = LeaveType::find($request->id);
        $total_leaves_days = $leavetypes->no_of_days;
        $balance_days = $total_leaves_days -$total_paid_leavedays;
        return response()->json($balance_days);
    }
}
