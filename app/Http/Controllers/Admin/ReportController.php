<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Department;
use App\Models\Employee;
use App\Models\LeaveApplication;
use App\Models\LeaveType;
use App\Models\Designation;
use App\Models\Rank;
use App\Models\Settings;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;
use Auth;

class ReportController extends Controller
{
    // daily presents
    public function dailyPresents()
    {
        $daily_attendance = [];
        $departments = Department::pluck('department_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        return view('admin.reports.daily_presents',compact('daily_attendance','departments'));
    }

    public function daily_presents_report(Request $request)
    {
        $data         = $request->all();
        $department_id = $request->department_id;
        $date          = Carbon::parse($request->date)->format('Y-m-d');
        $setting = Settings::first();
        if($department_id == 'all' && $date!=''){
            $daily_attendance = Attendance::with(['employee'])->where('date',$date)->get();
            return view ('admin.reports.daily_presents_table',[
                'daily_attendance' => $daily_attendance,
                'setting'          => $setting
            ]);
        }elseif($department_id != 'all' && $date!='' ) {
            $daily_attendance = Attendance::with(['employee'])->where('date','=',$date)
                                            ->whereHas('employee',function($subQuery) use ($department_id){
                                                $subQuery->where('department_id', '=', $department_id);
                                            })->get();

            return view ('admin.reports.daily_presents_table',[
                'daily_attendance' => $daily_attendance,
                'setting'          => $setting
            ]);

        }

    }


    public function daily_absents_report(Request $request)
    {
        $department_id = $request->department_id;
        $date = Carbon::parse($request->date)->format('Y-m-d');
        if($department_id == null){
            $daily_attendance = Attendance::with(['employee'])->where('date',$date)->get();

            if (count($daily_attendance) > 0) {
                foreach ($daily_attendance as $val) {
                    $emp_id[] = $val->employee_id;
                }
                $daily_attendance_missed_employee = Employee::where('is_active',1)->whereNotIn('id',$emp_id)->where('is_attendence',1)->get();
            }else{
                $daily_attendance_missed_employee =[];
            }
        }else {
            $daily_attendance = Attendance::join('employees','employees.id','=','attendances.employee_id')
                                      ->where('employees.department_id',$department_id)
                                      ->where('date',$date)
                                       ->select('attendances.*')->get();


            if (count($daily_attendance) > 0) {
                foreach ($daily_attendance as $val) {
                    $emp_id[] = $val->employee_id;
                }
                $daily_attendance_missed_employee = Employee::where('is_active',1)->whereNotIn('id',$emp_id)->where('is_attendence',1)->get();
            }else{
                $daily_attendance_missed_employee =[];
            }
        }
        $setting = Settings::first();
        return view ('admin.reports.daily_absents_table',[
            'daily_absence_list' => $daily_attendance_missed_employee,
            'setting'          => $setting,
            'absent_date' => $date,
        ]);
    }


    // monthly presents
    public function monthlyPresents()
    {
        $employees = Employee::where('is_active',1)->where('is_attendence',1)->get();
        $departments = Department::pluck('department_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $monthly_leave = [];
        $emp_id = "0" ;
        $setting = Settings::first();
        return view('admin.reports.monthly_presents',compact('setting','emp_id','monthly_leave','departments','employees'));
    }


    public function monthly_presents_report( Request $request)
    {

        $employee_id = $request->employee_id;
        if ($employee_id == null) {
            $emp_id = "0" ;
        }else{
            $emp_id = $employee_id ;
        }
        $year = $request->year;
        $month = $request->month;
        $start_date = $year.'-'.$month.'-'.'01';
        $end_date = $year.'-'.$month.'-'.'31';
        $model = Attendance::query();
        if ($emp_id){
            $model->where('employee_id', $emp_id)->where('date','>=',$start_date)->where('date','<=',$end_date);
        }else{
            $model->where('date','>=',$start_date)->where('date','<=',$end_date);
        }
        $monthly_leave = $model->get();
        $setting = Settings::first();
        return view ('admin.reports.monthly_presents_table',[
            'monthly_attendance' => $monthly_leave,
            'setting'          => $setting
        ]);
    }


    public function monthly_absents_report( Request $request)
    {
        $employee_id = $request->employee_id;
        $year = $request->year;
        $month = $request->month;
        $date = Carbon::parse($year."-".$month."-01");
        $start = $date->startOfMonth()->format('Y-m-d');
        $end = $date->endOfMonth()->format('Y-m-d');
        $start_date = Carbon::parse($start);
        $end_date = Carbon::parse($end);

        $dates = [];
        while ($start_date->lte($end_date)) {
            $dates[] = $start_date->copy();
            $start_date->addDay();
        }
        $alldate=[];
        foreach ($dates as $date){
           $alldate[] = Carbon::parse( $date)->format('Y-m-d');
          }
        $monthly_absent = Attendance::where('employee_id',$employee_id)->whereIn('date',$alldate)->get();
        if (count($monthly_absent) > 0) {
            foreach ($monthly_absent as $val) {
                $attend_date = strtotime($val->date);
                foreach ($alldate as $key => $date) {
                    $unixdate = strtotime($date);
                    if ($unixdate == $attend_date) {
                        unset($alldate[$key]);
                    }
                }
            }
        }

        $absent_employee = Employee::find($employee_id);
        $setting = Settings::first();
        return view ('admin.reports.monthly_absents_table',[
            'absent_employee' => $absent_employee,
            'setting'          => $setting,
            'alldate'          => $alldate,

        ]);

    }

    public function monthly_attendance_pdf($employee_id,$year,$month)
    {
        $start_date = $year.'-'.$month.'-'.'01';
        $end_date = $year.'-'.$month.'-'.'31';
        $model = Attendance::query();
        if ($employee_id != 0){
            $model->where('employee_id', $employee_id)->where('date','>=',$start_date)->where('date','<=',$end_date);
        }else{

            $model->where('date','>=',$start_date)->where('date','<=',$end_date);
        }
        $monthly_leave = $model->get();

        $pdf = PDF::loadview('admin.pdf.monthly_Attendance_pdf', compact('monthly_leave'));
        return $pdf->setPaper('a4')->stream('report.pdf');
    }


    // daily absents
    public function dailyAbsents()
    {
        $departments = Department::pluck('department_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $daily_attendance_missed_employee =[];
        $setting = Settings::first();
        $date = '';
        return view('admin.reports.daily_absents',compact('date','setting','daily_attendance_missed_employee','departments'));
    }
    // monthly absents
    public function monthlyAbsents()
    {
        $employees = Employee::where('is_active',1)->where('is_attendence',1)->get();
        $alldate=[];
        $departments = Department::pluck('department_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        return view('admin.reports.monthly_absents',compact('alldate','departments','employees'));
    }

    // employee on leave
    public function employeeOnLeave()
    {
        $employees = Employee::where('is_active',1)->get();
        $departments = Department::pluck('department_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $leave_applications = [];
        return view('admin.reports.employee_on_leave',compact('leave_applications','departments', 'employees'));
    }

    // leave log history
    public function leaveLogHistory()
    {
        $employees = Employee::where('is_active',1)->get();
        $leaveTypes = LeaveType::with(['department', 'company', 'created_by'])->get();
        $departments = Department::pluck('department_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $leave_log_history = [];
        return view('admin.reports.leave_log_history',compact('leaveTypes','employees','departments','leave_log_history'));
    }

    public function leaveLogHistorySearch( Request $request)
    {

        $employee_id = $request->employee_id;
        $department_id = $request->department_id;
        $start = Carbon::parse($request->start_date)->format('Y-m-d');
        $end = Carbon::parse($request->end_date)->format('Y-m-d');

        $query = new LeaveApplication();
        if($employee_id)
        {
            $query =  $query->where('employee_id',$employee_id);
        }
        if($department_id)
        {
            $query =  $query->where('department_id',$department_id);
        }
        if($request->start_date != null && $request->end_date != null)
        {
            $query =  $query->where('start_date','>=',$start)->where('end_date','<=',$end);
        }
        $leave_log_history = $query->select('employee_id')->groupBy('employee_id')->get();
        $auth_company_id = Auth::user()->company_id;
        $leaveTypes = LeaveType::with(['department', 'company', 'created_by'])->where('company_id',$auth_company_id)->get();
        $setting = Settings::first();
        return view ('admin.reports.leave_log_history_table',[
            'leaveTypes' => $leaveTypes,
            'setting'          => $setting,
            'leave_log_history'=> $leave_log_history,

        ]);
    }


    // employee on leave
    public function leaveReportSearch( Request $request)
    {
        $employee_id = $request->employee_id;
        $start = Carbon::parse($request->start_date)->format('Y-m-d');
        $end = Carbon::parse($request->end_date)->format('Y-m-d');
        $department_id = $request->department_id;

        $query = new LeaveApplication();
        if($employee_id)
        {
            $query =  $query->where('employee_id',$employee_id);
        }
        if($department_id)
        {
            $query =  $query->where('department_id',$department_id);
        }
        if($request->start_date != null && $request->end_date != null)
        {
            $query =  $query->where('start_date','>=',$start)->where('end_date','<=',$end);
        }
        $leave_applications = $query->get();
        if (count($leave_applications) > 0 ){

        $setting = Settings::first();
        return view ('admin.reports.employee_on_leave_table',[
            'leave_applications' => $leave_applications,
            'setting'          => $setting,
        ]);

       }else{
            return redirect()->route('employee_on_leave.reports')->with('error','Oops ! No Data Found .');
        }
    }




    // demographical report
    public function demographicalReport()
    {
        $employees = Employee::pluck('first_name', 'last_name', 'father_name', 'mother_name','address','email','contact_no','marital_status')->prepend(trans('global.pleaseSelect'));
        return view('admin.reports.demographical_report',compact('employees'));
    }

    // positional report
    public function positionalReport()
    {
        $employees = Employee::pluck('first_name','joining_date','tax','id')->prepend(trans('global.pleaseSelect'));
        $departments = Department::pluck('department_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $designations = Designation::pluck('designation_name','id')->prepend(trans('global.pleaseSelect'));
        $ranks = Rank::pluck('rank','id')->prepend(trans('global.pleaseSelect'));
        return view('admin.reports.positional_report',compact('employees','departments','designations'));
    }
}
