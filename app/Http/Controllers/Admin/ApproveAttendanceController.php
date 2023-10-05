<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Models\AttLog;
use Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Roster;
use App\Models\Rule;
use App\Models\Shift;
use Illuminate\Http\Request;
class ApproveAttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('attendance_approve_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $approve_attendance  = AttLog::orderBy('id','DESC')->where('status', 0)->paginate(20);

        return view('admin.approve_attendance.index', compact('approve_attendance'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $attendance_show = AttLog::find($id);
        $latitude = $attendance_show->latitude;
        $longitude = $attendance_show->longitude;

        return view('admin.approve_attendance.show', compact('attendance_show',  'latitude', 'longitude'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function attendanceApproved($id)
    {
        $attendance_approved = AttLog::find($id);
        $attendance_approved->status = 1;
        $attendance_approved->save();

        return redirect()->route('admin.approveattendance.index')->with('message', 'Approved Successfully!');
    }
    public function attendanceProcessIndex()
    {
        $lastAtt = Attendance::orderBy('id', 'DESC')->first();
        
        return view('admin.approve_attendance.attProIn',compact('lastAtt'));
    }
    public function attendanceProcessing(Request $request)
    {
        
    
       $employees = Employee::where('is_active',1)->get();
      
        $attLogs = AttLog::whereBetween('authDate',[$request->start_date,$request->end_date])->where('status',1)->get();

            foreach($employees as $employee){
                foreach($attLogs as $attLog){

                    $attendanceTable = Attendance::where('employee_id',$employee->id)->where('date',$attLog->authDate)->first();
                          
                        if($attendanceTable == null){
                            
                            $attLogsFirst = AttLog::where('employee_id',$employee->id)->where('authDate',$attLog->authDate)->where('status',1)->orderBy('created_at', 'asc')->first();
                            $attLogsLast = AttLog::where('employee_id',$employee->id)->where('authDate',$attLog->authDate)->where('status',1)->orderBy('created_at', 'desc')->first();
                           
                            if($attLogsFirst != null &&  $attLogsLast != null){
                                if ($employee->attendance_type == 'Branch') {
                                    $rules = Rule::where('type','like','%'.'time'.'%')->first();
                                    if ($rules == null){
                                        return redirect()->route('admin.attendanceProcess.index')->with('error','Oops ! Please Setup a Rule First !.');
                                    }
                        
                                    $system_start = $rules->start_time;
                                    $system_out = $rules->end_time;
                                    $enter_time = strtotime($attLogsFirst->authTime);
                                    $start_time = strtotime($system_start);
                                    if($enter_time > $start_time ){
                                        $data['late'] = Helper::getTime($attLogsFirst->authTime,$system_start);
                                    }
                                    $data['date'] = $attLogsFirst->authDate;
                                    $data['clock_in'] = $attLogsFirst->authTime;
                                    $data['employee_id'] = $attLogsFirst->employee_id;
                                    $data['area'] = $attLogsFirst->location;
                                    $attendance = Attendance::create($data);

                                    $attendanceUpdate = Attendance::findOrFail($attendance->id);
                                    $exit_time = strtotime($attLogsLast->authTime);
                                    $end_time = strtotime($system_out);
                                    if ($end_time > $exit_time ){
                                        $updateData['early_leaving'] = Helper::getTime($system_out,$attLogsLast->authTime);
                                    }
                                    $updateData['total_work'] = Helper::getTime($attendanceUpdate->clock_in,$attLogsLast->authTime);
                                    $updateData['clock_out'] = $attLogsLast->authTime;
                                    $updateData['leave_location'] = $attLogsLast->location;
                                    $attendanceUpdate->update($updateData);
                                    
                                }
                                else if ($employee->attendance_type == 'Roster') {
                                    $roster = Roster::where('employee_id',$employee->id)->where('duty_date',$attLog->authDate)->first();
                                    if ($roster == null){
                                        return redirect()->route('admin.attendanceProcess.index')->with('error','Oops ! Please Setup a Rule First !.');
                                    }
                                    if ($roster != null){
                                        $system_start = $roster->start_time;
                                        $system_out = $roster->end_time;
                                        $enter_time = strtotime($attLogsFirst->authTime);
                                        $start_time = strtotime($system_start);
                                        if($enter_time > $start_time ){
                                            $data['late'] = Helper::getTime($attLogsFirst->authTime,$system_start);
                                        }
                                        $data['date'] = $attLogsFirst->authDate;
                                        $data['clock_in'] = $attLogsFirst->authTime;
                                        $data['employee_id'] = $attLogsFirst->employee_id;
                                        $data['area'] = $attLogsFirst->location;
                                        $attendance = Attendance::create($data);

                                        $attendanceUpdate = Attendance::findOrFail($attendance->id);
                                        $exit_time = strtotime($attLogsLast->authTime);
                                        $end_time = strtotime($system_out);
                                        if ($end_time > $exit_time ){
                                            $updateData['early_leaving'] = Helper::getTime($system_out,$attLogsLast->authTime);
                                        }
                                        $updateData['total_work'] = Helper::getTime($attendance->clock_in,$attLogsLast->authTime);
                                        $updateData['clock_out'] = $attLogsLast->authTime;
                                        $updateData['leave_location'] = $attLogsLast->location;
                                        $attendanceUpdate->update($updateData);
                                        
                                    }                                                                                    
                                    
                                }
                                else{
                                    $shift = Shift::findOrFail($employee->shift_id);
                                    if ($shift == null){
                                        return redirect()->route('admin.attendanceProcess.index')->with('error','Oops ! Please Setup a Rule First !.');
                                    }
                                    $system_start = $shift->start_time;
                                    $system_out = $shift->end_time;
                                    $enter_time = strtotime($attLogsFirst->authTime);
                                    $start_time = strtotime($system_start);
                                    if($enter_time > $start_time ){
                                        $data['late'] = Helper::getTime($attLogsFirst->authTime,$system_start);
                                    }
                                    $data['date'] = $attLogsFirst->authDate;
                                    $data['clock_in'] = $attLogsFirst->authTime;
                                    $data['employee_id'] = $attLogsFirst->employee_id;
                                    $data['area'] = $attLogsFirst->location;
                                    $attendance = Attendance::create($data);

                                    $attendanceUpdate = Attendance::findOrFail($attendance->id);
                                    $exit_time = strtotime($attLogsLast->authTime);
                                    $end_time = strtotime($system_out);
                                    if ($end_time > $exit_time ){
                                        $updateData['early_leaving'] = Helper::getTime($system_out,$attLogsLast->authTime);
                                    }
                                    $updateData['total_work'] = Helper::getTime($attendance->clock_in,$attLogsLast->authTime);
                                    $updateData['clock_out'] = $attLogsLast->authTime;
                                    $updateData['leave_location'] = $attLogsLast->location;
                                    $attendanceUpdate->update($updateData);
                                }
                            }
                             else if($attLogsFirst != null &&  $attLogsLast == null)   {

                                if ($employee->attendance_type == 'Branch') {
                                    $rules = Rule::where('type','like','%'.'time'.'%')->first();
                                    if ($rules == null){
                                        return redirect()->route('admin.attendanceProcess.index')->with('error','Oops ! Please Setup a Rule First !.');
                                    }
                        
                                    $system_start = $rules->start_time;
                                    $system_out = $rules->end_time;
                                    $enter_time = strtotime($attLogsFirst->authTime);
                                    $start_time = strtotime($system_start);
                                    if($enter_time > $start_time ){
                                        $data['late'] = Helper::getTime($attLogsFirst->authTime,$system_start);
                                    }
                                    $data['date'] = $attLogsFirst->authDate;
                                    $data['clock_in'] = $attLogsFirst->authTime;
                                    $data['employee_id'] = $attLogsFirst->employee_id;
                                    $data['area'] = $attLogsFirst->location;
                                    $attendance = Attendance::create($data);                                   
                                
                                    
                                }
                                else if ($employee->attendance_type == 'Roster') {
                                    $roster = Roster::where('employee_id',$employee->id)->where('duty_date',$attLog->authDate)->first();
                                    if ($roster != null){
                                        $system_start = $roster->start_time;
                                        $system_out = $roster->end_time;
                                        $enter_time = strtotime($attLogsFirst->authTime);
                                        $start_time = strtotime($system_start);
                                        if($enter_time > $start_time ){
                                            $data['late'] = Helper::getTime($attLogsFirst->authTime,$system_start);
                                        }
                                        $data['date'] = $attLogsFirst->authDate;
                                        $data['clock_in'] = $attLogsFirst->authTime;
                                        $data['employee_id'] = $attLogsFirst->employee_id;
                                        $data['area'] = $attLogsFirst->location;
                                        $attendance = Attendance::create($data);                                       
                                        
                                    }                                                                                    
                                    
                                }
                                else{
                                    $shift = Shift::findOrFail($employee->shift_id);
                                    $system_start = $shift->start_time;
                                    $system_out = $shift->end_time;
                                    $enter_time = strtotime($attLogsFirst->authTime);
                                    $start_time = strtotime($system_start);
                                    if($enter_time > $start_time ){
                                        $data['late'] = Helper::getTime($attLogsFirst->authTime,$system_start);
                                    }
                                    $data['date'] = $attLogsFirst->authDate;
                                    $data['clock_in'] = $attLogsFirst->authTime;
                                    $data['employee_id'] = $attLogsFirst->employee_id;
                                    $data['area'] = $attLogsFirst->location;
                                    $attendance = Attendance::create($data);                                  
                                   
                                }
                               
                            }          
                        
                        } 
                        else if(!is_null($attendanceTable)){
                                $deleteExitAtt = $attendanceTable->delete();
                                $attLogsFirst = AttLog::where('employee_id',$employee->id)->where('authDate',$attLog->authDate)->where('status',1)->orderBy('created_at', 'asc')->first();
                            $attLogsLast = AttLog::where('employee_id',$employee->id)->where('authDate',$attLog->authDate)->where('status',1)->orderBy('created_at', 'desc')->first();
                           
                            if($attLogsFirst != null &&  $attLogsLast != null){
                                if ($employee->attendance_type == 'Branch') {
                                    $rules = Rule::where('type','like','%'.'time'.'%')->first();
                                    if ($rules == null){
                                        return redirect()->route('admin.attendanceProcess.index')->with('error','Oops ! Please Setup a Rule First !.');
                                    }
                        
                                    $system_start = $rules->start_time;
                                    $system_out = $rules->end_time;
                                    $enter_time = strtotime($attLogsFirst->authTime);
                                    $start_time = strtotime($system_start);
                                    if($enter_time > $start_time ){
                                        $data['late'] = Helper::getTime($attLogsFirst->authTime,$system_start);
                                    }
                                    $data['date'] = $attLogsFirst->authDate;
                                    $data['clock_in'] = $attLogsFirst->authTime;
                                    $data['employee_id'] = $attLogsFirst->employee_id;
                                    $data['area'] = $attLogsFirst->location;
                                    $attendance = Attendance::create($data);

                                    $attendanceUpdate = Attendance::findOrFail($attendance->id);
                                    $exit_time = strtotime($attLogsLast->authTime);
                                    $end_time = strtotime($system_out);
                                    if ($end_time > $exit_time ){
                                        $updateData['early_leaving'] = Helper::getTime($system_out,$attLogsLast->authTime);
                                    }
                                    $updateData['total_work'] = Helper::getTime($attendanceUpdate->clock_in,$attLogsLast->authTime);
                                    $updateData['clock_out'] = $attLogsLast->authTime;
                                    $updateData['leave_location'] = $attLogsLast->location;
                                    $attendanceUpdate->update($updateData);
                                    
                                }
                                else if ($employee->attendance_type == 'Roster') {
                                    $roster = Roster::where('employee_id',$employee->id)->where('duty_date',$attLog->authDate)->first();
                                    if ($roster != null){
                                        $system_start = $roster->start_time;
                                        $system_out = $roster->end_time;
                                        $enter_time = strtotime($attLogsFirst->authTime);
                                        $start_time = strtotime($system_start);
                                        if($enter_time > $start_time ){
                                            $data['late'] = Helper::getTime($attLogsFirst->authTime,$system_start);
                                        }
                                        $data['date'] = $attLogsFirst->authDate;
                                        $data['clock_in'] = $attLogsFirst->authTime;
                                        $data['employee_id'] = $attLogsFirst->employee_id;
                                        $data['area'] = $attLogsFirst->location;
                                        $attendance = Attendance::create($data);

                                        $attendanceUpdate = Attendance::findOrFail($attendance->id);
                                        $exit_time = strtotime($attLogsLast->authTime);
                                        $end_time = strtotime($system_out);
                                        if ($end_time > $exit_time ){
                                            $updateData['early_leaving'] = Helper::getTime($system_out,$attLogsLast->authTime);
                                        }
                                        $updateData['total_work'] = Helper::getTime($attendance->clock_in,$attLogsLast->authTime);
                                        $updateData['clock_out'] = $attLogsLast->authTime;
                                        $updateData['leave_location'] = $attLogsLast->location;
                                        $attendanceUpdate->update($updateData);
                                        
                                    }                                                                                    
                                    
                                }
                                else{
                                    $shift = Shift::findOrFail($employee->shift_id);
                                    $system_start = $shift->start_time;
                                    $system_out = $shift->end_time;
                                    $enter_time = strtotime($attLogsFirst->authTime);
                                    $start_time = strtotime($system_start);
                                    if($enter_time > $start_time ){
                                        $data['late'] = Helper::getTime($attLogsFirst->authTime,$system_start);
                                    }
                                    $data['date'] = $attLogsFirst->authDate;
                                    $data['clock_in'] = $attLogsFirst->authTime;
                                    $data['employee_id'] = $attLogsFirst->employee_id;
                                    $data['area'] = $attLogsFirst->location;
                                    $attendance = Attendance::create($data);

                                    $attendanceUpdate = Attendance::findOrFail($attendance->id);
                                    $exit_time = strtotime($attLogsLast->authTime);
                                    $end_time = strtotime($system_out);
                                    if ($end_time > $exit_time ){
                                        $updateData['early_leaving'] = Helper::getTime($system_out,$attLogsLast->authTime);
                                    }
                                    $updateData['total_work'] = Helper::getTime($attendance->clock_in,$attLogsLast->authTime);
                                    $updateData['clock_out'] = $attLogsLast->authTime;
                                    $updateData['leave_location'] = $attLogsLast->location;
                                    $attendanceUpdate->update($updateData);
                                }
                            }
                             else if($attLogsFirst != null &&  $attLogsLast == null)   {

                                if ($employee->attendance_type == 'Branch') {
                                    $rules = Rule::where('type','like','%'.'time'.'%')->first();
                                    if ($rules == null){
                                        return redirect()->route('admin.attendanceProcess.index')->with('error','Oops ! Please Setup a Rule First !.');
                                    }
                        
                                    $system_start = $rules->start_time;
                                    $system_out = $rules->end_time;
                                    $enter_time = strtotime($attLogsFirst->authTime);
                                    $start_time = strtotime($system_start);
                                    if($enter_time > $start_time ){
                                        $data['late'] = Helper::getTime($attLogsFirst->authTime,$system_start);
                                    }
                                    $data['date'] = $attLogsFirst->authDate;
                                    $data['clock_in'] = $attLogsFirst->authTime;
                                    $data['employee_id'] = $attLogsFirst->employee_id;
                                    $data['area'] = $attLogsFirst->location;
                                    $attendance = Attendance::create($data);                                   
                                
                                    
                                }
                                else if ($employee->attendance_type == 'Roster') {
                                    $roster = Roster::where('employee_id',$employee->id)->where('duty_date',$attLog->authDate)->first();
                                    if ($roster != null){
                                        $system_start = $roster->start_time;
                                        $system_out = $roster->end_time;
                                        $enter_time = strtotime($attLogsFirst->authTime);
                                        $start_time = strtotime($system_start);
                                        if($enter_time > $start_time ){
                                            $data['late'] = Helper::getTime($attLogsFirst->authTime,$system_start);
                                        }
                                        $data['date'] = $attLogsFirst->authDate;
                                        $data['clock_in'] = $attLogsFirst->authTime;
                                        $data['employee_id'] = $attLogsFirst->employee_id;
                                        $data['area'] = $attLogsFirst->location;
                                        $attendance = Attendance::create($data);                                       
                                        
                                    }                                                                                    
                                    
                                }
                                else{
                                    $shift = Shift::findOrFail($employee->shift_id);
                                    $system_start = $shift->start_time;
                                    $system_out = $shift->end_time;
                                    $enter_time = strtotime($attLogsFirst->authTime);
                                    $start_time = strtotime($system_start);
                                    if($enter_time > $start_time ){
                                        $data['late'] = Helper::getTime($attLogsFirst->authTime,$system_start);
                                    }
                                    $data['date'] = $attLogsFirst->authDate;
                                    $data['clock_in'] = $attLogsFirst->authTime;
                                    $data['employee_id'] = $attLogsFirst->employee_id;
                                    $data['area'] = $attLogsFirst->location;
                                    $attendance = Attendance::create($data);                                  
                                   
                                }
                               
                            } 
                               
                        }
                    
                }
                $data = null;
                $updateData = null;
                
            }
            return redirect()->route('admin.attendanceProcess.index')->with('message', 'Attendance process Successfully!');
    }
    
}
