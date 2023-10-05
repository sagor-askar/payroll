<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyLeaveApplicationRequest;
use App\Http\Requests\StoreLeaveApplicationRequest;
use App\Http\Requests\UpdateLeaveApplicationRequest;
use App\Models\Company;
use App\Models\Department;
use App\Models\Employee;
use App\Models\LeaveApplication;
use App\Models\LeaveType;
use App\Models\Role;
use App\Models\Settings;
use App\Models\SubCompany;
use App\Models\User;
use Gate;
use Auth;
use DateTime;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use PDF;
class LeaveApplicationController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('leave_application_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $role_title =auth()->user()->roles->first()->title;
        if ($role_title == 'Employee') {
            $employee_id = Auth::user()->employee_id;
            $leaveApplications = LeaveApplication::with(['department', 'company', 'employee', 'leave_type', 'media'])->where('employee_id',$employee_id)->paginate(20);
        }elseif($role_title == 'HR'){
            $employee_id = Auth::user()->employee_id;
            $leaveApplications = LeaveApplication::with(['department', 'company', 'employee', 'leave_type', 'media'])->where('approved_by',$employee_id)->paginate(20);
        }else{
            $leaveApplications = LeaveApplication::with(['department', 'company', 'employee', 'leave_type', 'media'])->paginate(20);
        }
        return view('admin.leaveApplications.index', compact('leaveApplications'));
    }

    public function create()
    {
        abort_if(Gate::denies('leave_application_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $departments = Department::pluck('department_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $company_id =   Auth::user()->company_id;
        $employee_id =   Auth::user()->employee_id;
        $sub_companies = SubCompany::where('company_id',$company_id)->pluck('sub_company_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $companies = Company::where('id',$company_id)->pluck('comp_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $auth_company_id = Auth::user()->company_id;
        $role_title =auth()->user()->roles->first()->title;
        if ($role_title == 'Employee'){
            $employee_detail = Employee::find($employee_id);
            $assign_employees = Employee::where('is_active',1)->where('department_id',$employee_detail->department_id)->get();
            $user_employees = Employee::where('is_active',1)->where('id',$employee_id)->get();
        }else{
            $assign_employees = Employee::where('is_active',1)->get();
            $user_employees = Employee::join('users','employees.id','=','users.employee_id')
                ->where('users.company_id',$auth_company_id)
                ->where('employees.is_active',1)
                ->select('employees.*')->get();
        }

        $roles = Role::where('title','=','HR')->first();
        $users = User::where('role_id',$roles->id)->get();

        foreach ($users as $val){
            $emp_id[] = $val->employee_id;
        }
        $approved_employees = Employee::where('is_active',1)->whereIn('id',$emp_id)->get();

        $leave_types = LeaveType::pluck('leave_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.leaveApplications.create', compact('assign_employees','role_title','user_employees','sub_companies','companies', 'departments', 'approved_employees', 'leave_types'));
    }

    public function store(StoreLeaveApplicationRequest $request)
    {

        $data =  $request->all();
        $employee_id = $request->employee_id;
        $role_title =auth()->user()->roles->first()->title;

        if ($role_title == 'Employee'){
            $data['company_id'] = Auth::user()->company_id;
            $employee_detail = Employee::find($employee_id);
            $sub_company = Department::where('id',$employee_detail->department_id)->where('company_id', $data['company_id'])->first();
            $data['sub_company_id'] = $sub_company->sub_company_id;
            $data['department_id'] = $employee_detail->department_id;
        }
        $fdate = $request->start_date;
        $tdate = $request->end_date;
        $datetime1 = new DateTime($fdate);
        $datetime2 = new DateTime($tdate);
        $interval = $datetime1->diff($datetime2);
        $days = $interval->format('%a') + 1 ;
        $data['no_of_days'] = $days ;
        $total_leave  = LeaveType::where('id',$request->leave_type_id)->first()->no_of_days;
        $total_paid_leavedays  = LeaveApplication::where('leave_type_id',$request->leave_type_id)->where('employee_id',$employee_id)->where('company_id', $data['company_id'])->where('department_id',$data['department_id'])->where('status',1)->get()->sum('no_of_days');
        $remaining_leave = $total_leave - $total_paid_leavedays;
        if ($days > $remaining_leave){
            return redirect()->route('admin.leave-applications.create')->with('warning','Oops ! Your Remaining Leave is ' .$remaining_leave.' Days.');
        }else {
            $leaveApplication = LeaveApplication::create($data);
            if ($request->input('doc', false)) {
                $leaveApplication->addMedia(storage_path('tmp/uploads/' . basename($request->input('doc'))))->toMediaCollection('doc');
            }

            if ($media = $request->input('ck-media', false)) {
                Media::whereIn('id', $media)->update(['model_id' => $leaveApplication->id]);
            }
            return redirect()->route('admin.leave-applications.index')->with('message', 'Leave application successfully');
        }
    }

    public function edit($id)
    {
        abort_if(Gate::denies('leave_application_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $leaveApplication  = LeaveApplication::with(['department','company','leave_type','employee'])->where('id',$id)->first();
        $role_title =auth()->user()->roles->first()->title;
        if ($role_title == 'Employee'){
            $employee_id =   Auth::user()->employee_id;
            $auth_company_id = Auth::user()->company_id;
            $employee_detail = Employee::find($employee_id);
            $assing_employees = Employee::where('is_active',1)->where('department_id',$employee_detail->department_id)->get();
            $user_employees = Employee::where('is_active',1)->where('id',$employee_id)->get();
        }else{
            $employees = Employee::find($leaveApplication->employee_id);
            $employee_id =   $employees->id;
            $department_id = $employees->department_id;
            $departments =Department::find($department_id);
            $auth_company_id =   $departments->company_id;
            $assing_employees = Employee::where('is_active',1)->get();
            $user_employees = Employee::join('users','employees.id','=','users.employee_id')
                ->where('users.company_id',$auth_company_id)
                 ->where('employees.is_active',1)
                ->select('employees.*')->get();
        }
        $departments = Department::pluck('department_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $companies = Company::where('id',$auth_company_id)->pluck('comp_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $sub_companies = SubCompany::where('company_id',$auth_company_id)->pluck('sub_company_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $roles = Role::where('title','=','HR')->first();
        $users = User::where('role_id',$roles->id)->get();
        foreach ($users as $val){
            $emp_id[] = $val->employee_id;
        }
        $approved_employees = Employee::where('is_active',1)->whereIn('id',$emp_id)->get();

        $leave_types = LeaveType::pluck('leave_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        return view('admin.leaveApplications.edit', compact('approved_employees','role_title','user_employees','sub_companies','companies', 'departments', 'assing_employees', 'leaveApplication', 'leave_types'));
    }

    public function update(UpdateLeaveApplicationRequest $request, LeaveApplication $leaveApplication)
    {

        $data =  $request->all();
        $employee_id = $request->employee_id;
        $role_title =auth()->user()->roles->first()->title;
        if ($role_title == 'Employee'){
            $data['company_id'] = Auth::user()->company_id;
            $employee_detail = Employee::find($employee_id);
            $sub_company = Department::where('id',$employee_detail->department_id)->where('company_id', $data['company_id'])->first();
            $data['sub_company_id'] = $sub_company->sub_company_id;
            $data['department_id'] = $employee_detail->department_id;
        }
        $fdate = $request->start_date;
        $tdate = $request->end_date;
        $datetime1 = new DateTime($fdate);
        $datetime2 = new DateTime($tdate);
        $interval = $datetime1->diff($datetime2);
        $days = $interval->format('%a') + 1 ;
        $data['no_of_days'] = $days ;
        $total_leave  = LeaveType::where('id',$request->leave_type_id)->first()->no_of_days;
        $total_paid_leavedays  = LeaveApplication::where('leave_type_id',$request->leave_type_id)->where('employee_id',$employee_id)->where('company_id', $data['company_id'])->where('department_id',$data['department_id'])->where('status',1)->get()->sum('no_of_days');
        $remaining_leave = $total_leave - $total_paid_leavedays;
        if ($days > $remaining_leave){
            return redirect()->back()->with('warning','Oops ! Your Remaining Leave is ' .$remaining_leave.' Days.');
        }else {
            $leaveApplication->update($data);
            if ($request->input('doc', false)) {
                if (!$leaveApplication->doc || $request->input('doc') !== $leaveApplication->doc->file_name) {
                    if ($leaveApplication->doc) {
                        $leaveApplication->doc->delete();
                    }
                    $leaveApplication->addMedia(storage_path('tmp/uploads/' . basename($request->input('doc'))))->toMediaCollection('doc');
                }
            } elseif ($leaveApplication->doc) {
                $leaveApplication->doc->delete();
            }
            return redirect()->route('admin.leave-applications.index');
        }
    }

    public function show($id)
    {
        abort_if(Gate::denies('leave_application_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $role_title =auth()->user()->roles->first()->title;
        $leaveApplication  = LeaveApplication::with(['department','company','leave_type','employee'])->where('id',$id)->first();

        $leaveApplication_history  = LeaveApplication::with(['department','company','leave_type','employee'])->where('employee_id',$leaveApplication->employee_id)->where('id','!=',$id)->get();

        return view('admin.leaveApplications.show', compact('leaveApplication_history','role_title','leaveApplication'));
    }

    public function destroy(LeaveApplication $leaveApplication)
    {
        abort_if(Gate::denies('leave_application_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $leaveApplication->delete();

        return back();
    }

    public function massDestroy(MassDestroyLeaveApplicationRequest $request)
    {
        LeaveApplication::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('leave_application_create') && Gate::denies('leave_application_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new LeaveApplication();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }


    public function leaveApproved($id)
    {
        $leave_application = LeaveApplication::find($id);
        $leave_application->status = 1 ;
        $leave_application->save();
        return redirect()->route('admin.leave-applications.index')->with('message', 'Application approved successfully');
    }

    public function leaveApprovedPDF($id)
    {
        $setting = Settings::first();
        $leave_application = LeaveApplication::find($id);
        $pdf = PDF::loadview('admin.leaveApplications.print_leave', compact('setting','leave_application'))->setOptions(['defaultFont' => 'sans-serif']);
        return $pdf->setPaper('a4')->stream('report.pdf');
    }

    public function leaveReject($id)
    {
        $leave_application = LeaveApplication::find($id);
        $leave_application->status = 2 ;
        $leave_application->save();
        return redirect()->route('admin.leave-applications.index')->with('message', 'Application rejected successfully');
    }

    public function leaveCancel($id)
    {
        $leave_application = LeaveApplication::find($id);
        $leave_application->delete();
        return redirect()->route('admin.leave-applications.index')->with('message', 'Application cancel successfully');
    }


}
