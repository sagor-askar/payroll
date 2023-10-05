<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyAttendanceRequest;
use App\Http\Requests\StoreAttendanceRequest;
use App\Http\Requests\UpdateAttendanceRequest;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Roster;
use App\Models\Rule;
use App\Models\Shift;
use Carbon\Carbon;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;
use DateTime;
use Illuminate\Support\Facades\Storage;

class AttendanceController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('attendance_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $role_title =auth()->user()->roles->first()->title;
        if ($role_title == 'Employee'){
            $attendances = Attendance::with(['employee'])->where('employee_id',Auth::user()->employee_id)->latest()->paginate(20);
        }else{
            $attendances = Attendance::with(['employee'])->latest()->paginate(20);
        }

        return view('admin.attendances.index', compact('attendances'));
    }

    public function create()
    {
        abort_if(Gate::denies('attendance_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $role_id = Auth::user()->role_id;
        $auth_company_id = Auth::user()->company_id;
        $role_title =auth()->user()->roles->first()->title;
        if ($role_title == 'Employee'){
            $employees = Employee::where('is_active',1)->where('id',Auth::user()->employee_id)->get();
        }else{
            $employees = Employee::join('users','employees.id','=','users.employee_id')
                ->where('users.company_id',$auth_company_id)
                ->where('employees.is_attendence',1)
                ->where('employees.is_active',1)
                ->select('employees.*')->get();
        }
        return view('admin.attendances.create', compact('role_title','employees'));
    }
    public function appList()
    {
        
    }

    public function store(StoreAttendanceRequest $request)
    {
        $date = Carbon::parse($request->date)->format('Y-m-d');

        $checkAttendance = Attendance::where('employee_id',$request->employee_id)->where('date',$date)->first();
       if ($checkAttendance){
           return redirect()->route('admin.attendances.index')->with('error','Attendance Already Generated !');;
       }
    //    FOR LOCATION START
        $json = Storage::disk('local')->get('/json/postcode-pretty.json');
        $arrdata =  json_decode($json,true);

        foreach($arrdata as $key=>$value){
            if($key == $request->postal){
                $request['postal_code'] = $key;
                $request['area'] = $value['suboffice'];
                break;
            }
        }
    //    FOR LOCATION END
        $data = $request->all();
        $data['device_name'] = "Web";
        $checkEmployee = Employee::where('is_active',1)->where('id',$request->employee_id)->first();
        if ($checkEmployee->attendance_type == 'Branch') {
            $rules = Rule::where('type','like','%'.'time'.'%')->first();
            if ($rules == null){
                return redirect()->route('admin.attendances.index')->with('error','Oops ! Please Setup a Rule First !.');
            }

            $system_start = $rules->start_time;
            $enter_time = strtotime($request->clock_in);
            $start_time = strtotime($system_start);
            if($enter_time > $start_time ){
                $data['late'] = Helper::getTime($request->clock_in,$system_start);
            }
            $attendance = Attendance::create($data);
            return redirect()->route('admin.attendances.index')->with('message','Attendance Successfully');
        }elseif ($checkEmployee->attendance_type == 'Roster'){
            $roster = Roster::where('employee_id',$checkEmployee->id)->where('duty_date',$date)->first();
            if ($roster) {
                $system_start = $roster->start_time;
                $enter_time = strtotime($request->clock_in);
                $start_time = strtotime($system_start);
                if($enter_time > $start_time ){
                    $data['late']  = Helper::getTime($request->clock_in,$system_start);
                }
                $attendance = Attendance::create($data);
                return redirect()->route('admin.attendances.index')->with('message','Attendance Successfully');
            }

        }else{
            $shift = Shift::findOrFail($checkEmployee->shift_id);
            $system_start = $shift->start_time;
            $enter_time = strtotime($request->clock_in);
            $start_time = strtotime($system_start);
            if($enter_time > $start_time ){
                $data['late'] = Helper::getTime($request->clock_in,$system_start);
            }
            $attendance = Attendance::create($data);
            return redirect()->route('admin.attendances.index')->with('message','Attendance Successfully');
        }



    }

    public function storeAll( Request $request)
    {
        $data = $request->all();
        $rules = Rule::where('type','like','%'.'time'.'%')->first();
        if ($rules == null){
            return redirect()->route('admin.attendances.index')->with('error','Oops ! Please Setup a Rule First !.');
        }

        $system_start = $rules->start_time;
        $system_out = $rules->end_time;
        $start_time = strtotime($system_start);
        $end_time = strtotime($system_out);
        $date = $request->date;
        for ( $i = 0; $i < count($date); $i++) {
            $enter_time = strtotime($request->clock_in[$i]);
            $exit_time = strtotime($request->clock_out[$i]);
            if ($enter_time > $start_time ){
                $diff_enter = $enter_time - $start_time;
                $late = date('H:i:s', $diff_enter);
            }else{
                $late = null ;
            }
            if ($end_time > $exit_time ){
                $diff_exit = $end_time - $exit_time;
                $early_leaving = date('H:i:s', $diff_exit);
            }else{
                $early_leaving =null;
            }
            $diff_total_work = $exit_time - $enter_time ;
            $total_work= date('H:i:s', $diff_total_work);
            $attendance = new Attendance();
            $attendance->employee_id = $request->employee_id;
            $attendance->date = $date[$i];
            $attendance->clock_in = $request->clock_in[$i];
            $attendance->clock_out = $request->clock_out[$i];
            $attendance->late = $late;
            $attendance->early_leaving = $early_leaving;
            $attendance->total_work = $total_work;
            $attendance->save();
        }
        return redirect()->route('admin.attendances.index');
    }
    public function missAttenceStore( Request $request)
    {
        $data = $request->all();
        $rules = Rule::where('type','like','%'.'time'.'%')->first();
        if ($rules == null){
            return redirect()->route('admin.attendances.index')->with('error','Oops ! Please Setup a Rule First !.');
        }
        $system_start = $rules->start_time;
        $system_out = $rules->end_time;
        $enter_time = strtotime($request->clock_in);
        $start_time = strtotime($system_start);
        $exit_time = strtotime($request->clock_out);
        $end_time = strtotime($system_out);
        if ($enter_time > $start_time ){
            $diff_enter = $enter_time - $start_time;
            $data['late'] = date('H:i:s', $diff_enter);
        }
        if ($end_time > $exit_time ){
            $diff_exit = $end_time - $exit_time;
            $data['early_leaving'] = date('H:i:s', $diff_exit);
        }
        $diff_total_work = $exit_time - $enter_time ;
        $data['total_work'] = date('H:i:s', $diff_total_work);
        $attendance = Attendance::create($data);
        return redirect()->route('admin.attendances.index');
    }

    public function attendanceSetup( Request $request)
    {
        abort_if(Gate::denies('attendance_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $employee_info=  Employee::find($request->employee_id);
        $start_date = Carbon::parse($request->start_date);
        $end_date = Carbon::parse($request->end_date);
        $dates = [];
        while ($start_date->lte($end_date)) {
            $dates[] = $start_date->copy();
            $start_date->addDay();
        }

        $auth_company_id = Auth::user()->company_id;
        $role_title =auth()->user()->roles->first()->title;
        if ($role_title == 'Employee'){
            $employees = Employee::where('is_active',1)->where('id',Auth::user()->employee_id)->pluck('first_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        }else{
            $employees = Employee::join('users','employees.id','=','users.employee_id')
                ->where('users.company_id',$auth_company_id)
                ->where('employees.is_active',1)
                ->pluck('employees.first_name', 'employees.id')->prepend(trans('global.pleaseSelect'), '');
        }
        return view('admin.attendances.monthly',compact('employee_info','dates','role_title','employees'));
    }


    public function missingAttendanceSetup( Request $request)
    {

        $date = Carbon::parse($request->date)->format('Y-m-d');
        $employee_info=  Employee::find($request->employee_id);
        $attendence_info = Attendance::where('employee_id',$request->employee_id)->where('date',$date)->first();
        $auth_company_id = Auth::user()->company_id;
        $role_title =auth()->user()->roles->first()->title;
        if ($role_title == 'Employee'){
            $employees = Employee::where('is_active',1)->where('id',Auth::user()->employee_id)->pluck('first_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        }else{
            $employees = Employee::join('users','employees.id','=','users.employee_id')
                ->where('users.company_id',$auth_company_id)
                ->where('employees.is_active',1)
                ->pluck('employees.first_name', 'employees.id')->prepend(trans('global.pleaseSelect'), '');
        }

             return view('admin.attendances.missingAttendance',compact('attendence_info','date','employee_info','employees'));
    }


    public function lateEarlyAttendanceSearch( Request $request)
    {
         $employee_id = $request->employee_id;
         $year = $request->year;
         $month = $request->month;
        $number_of_day = cal_days_in_month(CAL_GREGORIAN,$month,$year);

        $start_date = $year.'-'.$month.'-'.'01';
        $end_date = $year.'-'.$month.'-'.'31';
        $attendances_history = Attendance::where('date','>=',$start_date)->where('date','<=',$end_date)->where('employee_id',$employee_id)->where('late','!=',null)->orWhere('early_leaving','!=',null)->get();
        $employee_info =  Employee::find($request->employee_id);
        $rules = Rule::where('type','like','%'.'time'.'%')->first();
        if ($rules == null){
            return redirect()->route('admin.attendances.index')->with('error','Oops ! Please Setup a Rule First !.');
        }
        $auth_company_id = Auth::user()->company_id;

        $role_title =auth()->user()->roles->first()->title;
        if ($role_title == 'Employee'){
            $employees = Employee::where('is_active',1)->where('id',Auth::user()->employee_id)->pluck('first_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        }else{
            $employees = Employee::join('users','employees.id','=','users.employee_id')
                ->where('users.company_id',$auth_company_id)
                ->where('employees.is_active',1)
                ->pluck('employees.first_name', 'employees.id')->prepend(trans('global.pleaseSelect'), '');
        }

        return view('admin.attendances.lateAndEarlyAttendance',compact('attendances_history','rules','employee_info','employees'));
    }

    public function edit(Attendance $attendance)
    {
        abort_if(Gate::denies('attendance_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $role_id = Auth::user()->role_id;
        $auth_company_id = Auth::user()->company_id;
        $role_title =auth()->user()->roles->first()->title;
        if ($role_title == 'Employee'){
            $employees = Employee::where('is_active',1)->where('id',Auth::user()->employee_id)->get();
        }else{
            $employees = Employee::join('users','employees.id','=','users.employee_id')
                ->where('users.company_id',$auth_company_id)
                ->where('employees.is_attendence',1)
                ->where('employees.is_active',1)
                ->select('employees.*')->get();
        }
        $attendance->load('employee');
        return view('admin.attendances.edit', compact('role_title','attendance', 'employees'));
    }

    public function update(UpdateAttendanceRequest $request, Attendance $attendance)
    {


         //    FOR LOCATION START
         $json = Storage::disk('local')->get('/json/postcode-pretty.json');
         $arrdata =  json_decode($json,true);

         foreach($arrdata as $key=>$value){
             if($key == $request->postal){
                 $request['postal_code'] = $key;
                 $request['area'] = $value['suboffice'];
                 break;
             }
         }
     //    FOR LOCATION END
        $data = $request->all();
        $checkEmployee = Employee::findOrFail($request->employee_id);
        if ($checkEmployee->attendance_type == 'Branch') {
            $rules = Rule::where('type','like','%'.'time'.'%')->first();
            if ($rules == null){
                return redirect()->route('admin.attendances.index')->with('error','Oops ! Please Setup a Rule First !.');
            }
            $system_out = $rules->end_time;

        }elseif ($checkEmployee->attendance_type == 'Roster'){
            $roster = Roster::where('employee_id',$checkEmployee->id)->where('duty_date',$request->date)->first();
            $system_out = $roster->end_time;

        }else{
            $shift = Shift::findOrFail($checkEmployee->shift_id);
            $system_out = $shift->end_time;
        }

        $attendance = Attendance::findOrFail($request->id);
        $enter_time = strtotime($attendance->clock_in);
        $exit_time = strtotime($request->clock_out);
        $end_time = strtotime($system_out);
        if ($end_time > $exit_time ){
            $data['early_leaving'] = Helper::getTime($system_out,$request->clock_out);
        }
        $data['total_work'] = Helper::getTime($attendance->clock_in,$request->clock_out);

         //    FOR LOCATION START
         $json = Storage::disk('local')->get('/json/postcode-pretty.json');
         $arrdata =  json_decode($json,true);

         foreach($arrdata as $key=>$value){
             if($key == $request->postal){
                 $request['leave_location'] = $value['suboffice'];
                 break;
             }
         }
     //    FOR LOCATION END
        $attendance->update($data);

        return redirect()->route('admin.attendances.index')->with('message','Attendance Update Successfully');
    }

    public function show(Attendance $attendance)
    {
        abort_if(Gate::denies('attendance_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $attendance->load('employee');
        return view('admin.attendances.show', compact('attendance'));
    }

    public function destroy(Attendance $attendance)
    {
        abort_if(Gate::denies('attendance_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $attendance->delete();
        return back();
    }

    public function massDestroy(MassDestroyAttendanceRequest $request)
    {
        Attendance::whereIn('id', request('ids'))->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }


    public function missingAttendance()
    {
        $role_id = Auth::user()->role_id;
        $auth_company_id = Auth::user()->company_id;
        $role_title =auth()->user()->roles->first()->title;
        if ($role_title == 'Employee'){
            $employees = Employee::where('is_active',1)->where('id',Auth::user()->employee_id)->pluck('first_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        }else{
            $employees = Employee::join('users','employees.id','=','users.employee_id')
                ->where('users.company_id',$auth_company_id)
                ->where('employees.is_attendence',1)
                ->where('employees.is_active',1)
                ->pluck('employees.first_name', 'employees.id')->prepend(trans('global.pleaseSelect'), '');
        }
        $attendence_info = null;
        $employee_info = null;
        return view('admin.attendances.missingAttendance',compact('employee_info','attendence_info','employees'));
    }


    public function lateAndEarlyAttendance()
    {

        $auth_company_id = Auth::user()->company_id;
        $role_title =auth()->user()->roles->first()->title;
        if ($role_title == 'Employee'){
            $employees = Employee::where('is_active',1)->where('id',Auth::user()->employee_id)->pluck('first_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        }else{
            $employees = Employee::join('users','employees.id','=','users.employee_id')
                ->where('users.company_id',$auth_company_id)
                ->where('employees.is_attendence',1)
                ->where('employees.is_active',1)
                ->pluck('employees.first_name', 'employees.id')->prepend(trans('global.pleaseSelect'), '');
        }
        $attendances_history = [];
        return view('admin.attendances.lateAndEarlyAttendance',compact( 'attendances_history','employees'));
    }



    public function user_attendance_details($employee_id,$start_date,$end_date)
    {
        $attendance_history = Attendance::with(['employee'])->where('employee_id',$employee_id)->where('date','>=',$start_date)->where('date','<=',$end_date)->get();
        return view('admin.attendances.user_attendance_details',compact('end_date','start_date','attendance_history'));
    }

    public function monthlyAttendanceView()
    {
        $auth_company_id = Auth::user()->company_id;
        $role_title =auth()->user()->roles->first()->title;
        if ($role_title == 'Employee'){
            $employees = Employee::where('is_active',1)->where('id',Auth::user()->employee_id)->pluck('first_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        }else{
            $employees = Employee::join('users','employees.id','=','users.employee_id')
                ->where('users.company_id',$auth_company_id)
                ->where('employees.is_attendence',1)
                ->where('employees.is_active',1)
                ->pluck('employees.first_name', 'employees.id')->prepend(trans('global.pleaseSelect'), '');
        }
        $dates = [];
        return view('admin.attendances.monthly',compact('dates','role_title','employees'));
    }
    public function attendanceLogReport()
    {
        $start_date = ' ' ;
        $end_date =' ' ;
        $year =' ';
        $role_id = Auth::user()->role_id;
        $auth_company_id = Auth::user()->company_id;
        $role_title =auth()->user()->roles->first()->title;
        if ($role_title == 'Employee'){
            $employees = Employee::where('is_active',1)->where('id',Auth::user()->employee_id)->pluck('first_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        }else{
            $employees = Employee::join('users','employees.id','=','users.employee_id')
                ->where('users.company_id',$auth_company_id)
                ->where('employees.is_attendence',1)
                ->where('employees.is_active',1)
                ->pluck('employees.first_name', 'employees.id')->prepend(trans('global.pleaseSelect'), '');
        }
        $attendances =[];
        return view('admin.attendances.log_report',compact('role_title','year','end_date','start_date','attendances','employees'));
    }

    public function attendanceLogSearch(Request $request)
    {

        $start_date = \Carbon\Carbon::parse( $request->start_date)->format('Y-m-d');
        $end_date = \Carbon\Carbon::parse( $request->end_date)->format('Y-m-d');
        $year = \Carbon\Carbon::parse( $request->end_date)->format('Y');
        $employee_id = $request->employee_id;
      if ($employee_id == null) {
          $attendances = Attendance::with(['employee'])->where('date', '>=', $start_date)->where('date', '<=', $end_date)->get();
      }else{
          $attendances = Attendance::with(['employee'])->where('employee_id',$employee_id)->where('date', '>=', $start_date)->where('date', '<=', $end_date)->get();
      }
        $role_id = Auth::user()->role_id;
        $auth_company_id = Auth::user()->company_id;
        $role_title =auth()->user()->roles->first()->title;
        if ($role_title == 'Employee'){
            $employees = Employee::where('is_active',1)->where('id',Auth::user()->employee_id)->pluck('first_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        }else{
            $employees = Employee::join('users','employees.id','=','users.employee_id')
                ->where('users.company_id',$auth_company_id)
                ->where('employees.is_active',1)
                ->pluck('employees.first_name', 'employees.id')->prepend(trans('global.pleaseSelect'), '');
        }
        return view('admin.attendances.log_report',compact('role_title','year','end_date','start_date','attendances','employees'));
    }

}
