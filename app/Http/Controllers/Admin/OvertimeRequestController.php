<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Overtime;
use App\Models\Company;
use App\Models\WeeklyHoliday;
use App\Models\SubCompany;
use App\Models\Holiday;
use App\Models\Rule;
use App\Models\Settings;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\Cast\Double;

class OvertimeRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ot_details = Overtime::paginate(20);

        return view('admin.attendances.overtime_request', compact('ot_details'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employees = Employee::where('is_active',1)->where('is_attendence',1)->get();

        return view('admin.attendances.create_ot_request', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = $request->all();
        $data['ot_date'] = Carbon::parse($request->ot_date)->format('Y-m-d');
        $employee_info = Employee::find($request->employee_id);
        $employee_salary = $employee_info->salary;
        $numberOfDaysInMonth = Carbon::now()->daysInMonth;
        $weeksIhisMonth      = $this->weeksInMonth($numberOfDaysInMonth);
        $leaveDays           = WeeklyHoliday::sum('weeklyleave');
        $monthHoliday        = Holiday::whereMonth('from_holiday','=',Carbon::now()->month)->sum('number_of_days');
        $totalHoliday        = (intval($weeksIhisMonth)) * (intval($leaveDays));
        $workingDays         = $numberOfDaysInMonth - $totalHoliday - $monthHoliday;
        $perDayAmount = $employee_salary /$workingDays;
        $times = Rule::first();
        $totatime = strtotime($times->end_time) - strtotime($times->start_time);
        $totalHour= date('H', $totatime) + (date('i', $totatime)/60);
        $data['hour_rate']= (int)($perDayAmount/$totalHour);
        $data['created_by'] = Auth::user()->id;
         Overtime::create($data);
        return redirect()->route('overtime_request.index')->with('message', 'Overtime Request Inserted');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ot_info = Overtime::find($id);
        $role_title =auth()->user()->roles->first()->title;
        return view('admin.attendances.show_ot_request', compact('role_title','ot_info'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ot_info = Overtime::find($id);
        $employees = Employee::where('is_active',1)->where('is_attendence',1)->get();
        return view('admin.attendances.edit_ot_request', compact('ot_info','employees'));
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
         $ot_info = Overtime::find($id);
        $data = $request->all();
        $data['ot_date'] = Carbon::parse($request->ot_date)->format('Y-m-d');

        $ot_info->update($data);
        return redirect()->route('overtime_request.index')->with('message', 'Overtime Request Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ot_info = Overtime::find($id);
        $ot_info->delete();
        return redirect()->route('overtime_request.index');
    }


    public function weeksInMonth($numOfDaysInMonth)
    {
        $daysInWeek = 7;
        $daysInMonth = $numOfDaysInMonth;
        $result = $daysInMonth/$daysInWeek;
        $numberOfFullWeeks = floor($result);
        $numberOfRemaningDays = ($result - $numberOfFullWeeks)*7;
        return $numberOfFullWeeks;
    }



    public function oTApproved($id)
    {
        $overtime= Overtime::find($id);
        $overtime->status = 1 ;
        $overtime->save();
        return redirect()->route('overtime_request.index')->with('message','OT Approved Successfully');
    }

    public function oTReject($id)
    {
        $overtime = Overtime::find($id);
        $overtime->status = 2 ;
        $overtime->save();
        return redirect()->route('overtime_request.index')->with('message','OT Rejected Successfully');
    }

    public function oTCancel($id)
    {
        $overtime = Overtime::find($id);
        $overtime->delete();
        return redirect()->route('overtime_request.index')->with('message','OT Cancel Successfully');
    }
}
