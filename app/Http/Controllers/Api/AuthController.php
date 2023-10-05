<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\AttLog;
use App\Models\Employee;
use App\Models\Roster;
use App\Models\Rule;
use App\Models\Shift;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UpdatePasswordRequest;
use App\Models\LeaveApplication;
use App\Models\LoanApplication;
use App\Models\SalaryAdvance;

class AuthController extends Controller
{
     public function login(Request $request)
    {
        try{
            $validator = Validator::make(
                $request->all(),
                [
                    'email'    => 'required|email',
                    'password' => 'required|string|min:6',
                ]
            );
             if ($validator->fails()) {
                return response()->json(['success' => false, 'error' => $validator->errors()], 422);
            }
            DB::beginTransaction();
            if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
            'message' => 'Invalid login details'
                    ], 401);
                }

            $user = User::where('email', $request['email'])->firstOrFail();

            $token = $user->createToken('auth_token')->plainTextToken;
            DB::commit();
            return response()->json(['success' => true, 'data' => $user,'access_token'=>$token], 200);

        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['success' => false, 'errmsg' => $e->getMessage()], 500);
        }

    }
    public function signout()
    {
        auth()->user()->tokens()->delete();
        return response()->json(['message' => 'User logged out successfully'],500);
    }
    public function dashBoard(Request $request)
    {
                $employeeTotalLeave = LeaveApplication::where('employee_id',$request->get('employee_id'))->whereStatus(1)->count();
                $employeeAdvancedSalary = SalaryAdvance::where('employee_id',$request->get('employee_id'))->whereStatus(1)->where('paid_status',0)->sum('amount');
                $employeeLoan = LoanApplication::where('employee_id',$request->get('employee_id'))->whereStatus(1)->sum('amount');
                $employeeLate = Attendance::where('employee_id',$request->get('employee_id'))->where('late','!=',null)->count();
                return response()->json([
                    'status' => true,
                    'employeeTotalLeave'=>$employeeTotalLeave,
                    'employeeAdvancedSalary'=>$employeeAdvancedSalary,
                    'employeeLoan'=>$employeeLoan,
                    'employeeLate'=>$employeeLate,
                ], 200);
    }

    public function attendanceList()
    {
        $attendances = Attendance::with(['employee'])->where('employee_id',Auth::user()->employee_id)->get();
        return response()->json(['success' => true, 'data' => $attendances], 200);
    }

    public function attendanceStore(Request $request)
    {
        try{
            $validator = Validator::make(
                $request->all(),
                [
                    'employee_id' => 'required',
                    'date'        => 'required',
                    'clock_in'    => 'required',
                ]
            );
             if ($validator->fails()) {
                return response()->json(['success' => false, 'error' => $validator->errors()], 422);
            }
            DB::beginTransaction();

            $date = Carbon::parse($request->date)->format('Y-m-d');
            $checkAttendance = Attendance::where('employee_id',$request->employee_id)->where('date',$date)->count();
            if ($checkAttendance){
                return response()->json(['success' => false, 'error' => 'Attendance Already Generated'], 422);
            }
            $data = $request->all();
            $data['device_name'] = "App";
            $checkEmployee = Employee::findOrFail($request->employee_id);
            if($checkEmployee->is_attendence != 1){
                return response()->json(['success' => false, 'error' => 'You are not eligible'], 422);
            }

            if ($checkEmployee->attendance_type == 'Branch') {
                    $rules = Rule::first();
                    $system_start = $rules->start_time;
                    $enter_time = strtotime($request->clock_in);
                    $start_time = strtotime($system_start);
                    if($enter_time > $start_time ){
                        $time = Helper::getTime($request->clock_in,$system_start);
                        $data['late'] = $time;
                    }
                    $attendance = Attendance::create($data);
                    DB::commit();
                    return response()->json(['success' => true, 'data' => $attendance], 200);
            }elseif ($checkEmployee->attendance_type == 'Roster'){
                $roster = Roster::where('employee_id',$checkEmployee->id)->where('duty_date',$request->date)->first();
                $system_start = $roster->start_time;
                $enter_time = strtotime($request->clock_in);
                $start_time = strtotime($system_start);
                if($enter_time > $start_time ){
                    $time = Helper::getTime($request->clock_in,$system_start);
                     $data['late'] = $time;
                }
                $attendance = Attendance::create($data);
                DB::commit();
                return response()->json(['success' => true, 'data' => $attendance], 200);
            }else{
                $shift = Shift::findOrFail($checkEmployee->shift_id);
                $system_start = $shift->start_time;
                $enter_time = strtotime($request->clock_in);
                $start_time = strtotime($system_start);
                if($enter_time > $start_time ){
                    $time = Helper::getTime($request->clock_in,$system_start);
                     $data['late'] = $time;
                }
                $attendance = Attendance::create($data);
                DB::commit();
                return response()->json(['success' => true, 'data' => $attendance], 200);
            }


        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['success' => false, 'errmsg' => $e->getMessage()], 500);
        }

    }
    public function attendanceReStore(Request $request)
    {
        try{
            $validator = Validator::make(
                $request->all(),
                [
                    'employee_id' => 'required',
                    'authDate'    => 'required',
                    'authTime'    => 'required',
                    'latitude'    => 'required',
                    'longitude'   => 'required',
                    'location'    => 'required',
                ]
            );
             if ($validator->fails()) {
                return response()->json(['success' => false, 'error' => $validator->errors()], 422);
            }
            DB::beginTransaction();
            $data = $request->all();
            $data['status'] = 0;
            $data['deviceName'] = "App";
            $attendance = AttLog::create($data);
            DB::commit();
            return response()->json(['success' => true, 'data' => $attendance], 200);

        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['success' => false, 'errmsg' => $e->getMessage()], 500);
        }

    }
   

     public function attendanceCheck(Request $request)
    {

        try{

            $date = Carbon::parse($request->get('date'))->format('Y-m-d');

            $checkAttendance = Attendance::where('employee_id',$request->get('employee_id'))->where('date',$date)->count();

            if ($checkAttendance){
                $todayNotLeave = Attendance::where('employee_id',$request->get('employee_id'))->where('date',$date)->first();

                if($todayNotLeave->clock_out != null){
                    return response()->json(['status' => 'todayleave','data'=>$todayNotLeave], 200);
                }
                else if($todayNotLeave->clock_out == null){
                    return response()->json(['status' => 'todaynotleave','data'=>$todayNotLeave], 200);
                }
                else{
                    return response()->json(['status' => 'generated','data'=>$todayNotLeave], 200);
                }
            }else{
                return response()->json(['status' => 'empty'], 200);
            }


        }catch(\Exception $e){
            return response()->json(['success' => false, 'errmsg' => $e->getMessage()], 500);
        }
    }
    public function attendanceUpdate(Request $request)
    {

        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'id' => 'required',
                    'employee_id' => 'required',
                    'date'        => 'required',
                    'clock_out'    => 'required',
                ]
            );
             if ($validator->fails()) {
                return response()->json(['success' => false, 'error' => $validator->errors()], 422);
            }
            DB::beginTransaction();
            $data = $request->all();
            $checkEmployee = Employee::findOrFail($request->employee_id);
            if ($checkEmployee->attendance_type == 'Branch') {
                $rules = Rule::first();
                $system_out = $rules->end_time;

            }elseif ($checkEmployee->attendance_type == 'Roster'){
                $roster = Roster::where('employee_id',$checkEmployee->id)->where('duty_date',$request->date)->first();
                $system_out = $roster->end_time;

            }else{
                $shift = Shift::findOrFail($checkEmployee->shift_id);
                $system_out = $shift->end_time;
            }
            $attendance = Attendance::where('employee_id',$request->employee_id)->where('date',Carbon::parse($request->date)->format('Y-m-d'))->first();
            $enter_time = strtotime($attendance->clock_in);
            $exit_time = strtotime($request->clock_out);
            $end_time = strtotime($system_out);
            if ($end_time > $exit_time ){

                $time = Helper::getTime($system_out,$request->clock_out);
                $data['early_leaving'] = $time;               
            }
            $time = Helper::getTime($attendance->clock_in,$request->clock_out);
            $data['total_work'] = $time;
            $attendance->update($data);
            DB::commit();
            return response()->json(['success' => true, 'data' => $attendance], 200);
        } catch(\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'errmsg' => $e->getMessage()], 500);
        }
    }
   
    public function attendanceLog(Request $request)
    {
        $attendanceLogs = Attendance::orderBy('id', 'DESC')->select('date','clock_in','clock_out','late')->where('employee_id',$request->get('employee_id'))->paginate(20);
        return response()->json(['success' => true, 'data' => $attendanceLogs], 200);
    }
    public function noticeBoard(Request $request)
    {
        $notices =  Auth::user()->unreadNotifications ;
        return response()->json(['success' => true, 'data' => $notices], 200);

    }
    public function userUpdate(UpdatePasswordRequest $request)
    {
        try{
            DB::beginTransaction();
            auth()->user()->update($request->validated());
            DB::commit();
            return response()->json(['status' => True, 'mesg' => 'Successfuly updated'], 200);
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['status' => false, 'mesg' => $e->getMessage()], 500);
        }

    }

}
