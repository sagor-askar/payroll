<?php

namespace App\Http\Controllers\admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\LateConsideration;
use App\Models\LeaveApplication;
use App\Models\Role;
use App\Models\Rule;
use App\Models\Settings;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Roster;
use App\Models\Shift;
use Auth;
use PDF;
use Gate;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class LateConsiderationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('late_consideration_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $role_title =auth()->user()->roles->first()->title;
        if ($role_title == 'Employee') {
            $employee_id = Auth::user()->employee_id;
            $lateConsider = LateConsideration::with(['employee','approved_employee'])->where('employee_id',$employee_id)->orderBy('id','DESC')->paginate(20);
        }elseif($role_title == 'HR'){
            $employee_id = Auth::user()->employee_id;
            $lateConsider = LateConsideration::orderBy('id','DESC')->with([ 'employee', 'approved_employee'])->where('approved_by',$employee_id)->paginate(20);
        }else{
            $lateConsider = LateConsideration::orderBy('id','DESC')->with(['employee', 'approved_employee'])->paginate(20);
        }
        return view('admin.lateConsideration.index', compact('lateConsider'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('late_consideration_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $employee_id =   Auth::user()->employee_id;
        $role_title =auth()->user()->roles->first()->title;
        if ($role_title == 'Employee'){
            $employees = Employee::where('is_active',1)->where('id',$employee_id)->get();
        }else{
            $employees = Employee::where('is_active',1)->where('is_attendence',1)->get();
        }
        $roles = Role::where('title','=','HR')->first();
        $users = User::where('role_id',$roles->id)->get();
        foreach ($users as $val){
            $emp_id[] = $val->employee_id;
        }
        $approved_employees = Employee::where('is_active',1)->whereIn('id',$emp_id)->get();
        return view('admin.lateConsideration.create', compact('approved_employees','role_title','employees'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            DB::beginTransaction();
            $checkEmployee = Employee::findOrFail($request->employee_id);
            if($checkEmployee->is_attendence != 1){
               return redirect()->with('error', 'You are not eligible');
            }
            $data              = $request->all();
            if ($checkEmployee->attendance_type == 'Branch') {
                $rules             = Rule::first();
                $data['clock_in']  = $rules->start_time;
                $data['clock_out'] = $rules->end_time;
           }elseif($checkEmployee->attendance_type == 'Roster'){
                $date              = Carbon::parse($request->date)->format('Y-m-d');
                $roster            = Roster::where('employee_id',$checkEmployee->id)->where('duty_date', $date)->first();
                $data['clock_in']  = $roster->start_time;
                $data['clock_out'] = $roster->end_time;
           }else{
                $shift             = Shift::findOrFail($checkEmployee->shift_id);
                $data['clock_in']  = $shift->start_time;
                $data['clock_out'] = $shift->end_time;
           }

            LateConsideration::create($data);

            DB::commit();
            return redirect()->route('admin.late-consideration.index')->with('message', 'Apply successfully');;
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->route('admin.late-consideration.index')->with('error', $e->getMessage());
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort_if(Gate::denies('late_consideration_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $role_title =auth()->user()->roles->first()->title;
        $lateConsider  = LateConsideration::with(['employee'])->where('id',$id)->first();
        $lateConsider_history  = LateConsideration::with(['employee'])->where('employee_id',$lateConsider->employee_id)->where('id','!=',$id)->get();
        return view('admin.lateConsideration.show', compact('lateConsider_history','role_title','lateConsider'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       abort_if(Gate::denies('late_consideration_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $lateConsider = LateConsideration::with(['employee','approved_employee'])->where('id',$id)->first();
        $employee_id =   Auth::user()->employee_id;
        $role_title =auth()->user()->roles->first()->title;
        if ($role_title == 'Employee'){
            $employees = Employee::where('is_active',1)->where('id',$employee_id)->get();
        }else{
            $employees = Employee::where('is_active',1)->where('is_attendence',1)->get();
        }
        $roles = Role::where('title','=','HR')->first();
        $users = User::where('role_id',$roles->id)->get();
        foreach ($users as $val){
            $emp_id[] = $val->employee_id;
        }
        $approved_employees = Employee::where('is_active',1)->whereIn('id',$emp_id)->get();
        return view('admin.lateConsideration.edit', compact('lateConsider','approved_employees','role_title','employees'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $rules = Rule::first();
        $data['clock_in'] = $rules->start_time;
        $data['clock_out'] = $rules->end_time;
        $lateConsider = LateConsideration::find($id);
        $lateConsider->update($data);
        return redirect()->route('admin.late-consideration.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('late_consideration_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $late_consider = LateConsideration::find($id);
        $late_consider->delete();
        return redirect()->route('admin.late-consideration.index');
    }


    public function lateApproved($id)
    {
        try{
            DB::beginTransaction();
            $late_consider= LateConsideration::find($id);
            $date = Carbon::parse($late_consider->date)->format('Y-m-d');
            $attendance = Attendance::where('employee_id',$late_consider->employee_id)->where('date',$date)->first();
        if ($attendance == null) {
            $data['employee_id'] = $late_consider->employee_id;
            $data['date'] = Carbon::parse($late_consider->date)->format('Y-m-d');
            $data['clock_in'] = $late_consider->clock_in;
            $data['clock_out'] = $late_consider->clock_out;
            $enter_time = strtotime($late_consider->clock_in);
            $exit_time = strtotime($late_consider->clock_out);
            $data['total_work'] = Helper::getTime($exit_time,$enter_time);
            Attendance::create($data);

        }else{
            $data['employee_id'] = $late_consider->employee_id;
            $data['date'] = Carbon::parse($late_consider->date)->format('Y-m-d');
            $data['clock_in'] = $late_consider->clock_in;
            $data['clock_out'] = $late_consider->clock_out;
            $enter_time = strtotime($late_consider->clock_in);
            $exit_time = strtotime($late_consider->clock_out);
            $data['total_work'] = Helper::getTime($exit_time,$enter_time);
            $data['late'] = null;
            $data['early_leaving'] = null;
            $attendance->update($data);
        }
        $late_consider->status = 1 ;
        $late_consider->save();
        DB::commit();
        return redirect()->route('admin.late-consideration.index')->with('message','Approved successfully');

        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->route('admin.late-consideration.index')->with('error',$e->getMessage());
        }

    }
    public function lateCancel($id)
    {
        $late_consider = LateConsideration::find($id);
        $late_consider->delete();
        return redirect()->route('admin.late-consideration.index');
    }
    public function lateReject($id)
    {
        $late_consider = LateConsideration::find($id);
        $late_consider->status = 2 ;
        $late_consider->save();
        return redirect()->route('admin.late-consideration.index')->with('message','Rejected successfully');
    }
    public function lateApprovedPDF($id)
    {
        $setting = Settings::first();
        $late_consider = LateConsideration::find($id);
        $pdf = PDF::loadview('admin.lateConsideration.print_late', compact('setting','late_consider'))->setOptions(['defaultFont' => 'sans-serif']);
        return $pdf->setPaper('a4')->stream('report.pdf');
    }
}
