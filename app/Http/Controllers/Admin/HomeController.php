<?php

namespace App\Http\Controllers\Admin;
use App\Models\Employee;
use App\Models\LeaveApplication;
use App\Models\LoanApplication;
use App\Models\SalaryAdvance;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
class HomeController
{
    public function index(Request $request)
    {

      
         
        
       

      
 

          
              if($request->ajax()) {
                    $leaves = LeaveApplication::with(['employee'])->where('status',1)->get();
                    return response()->json([
                      'leaves' => $leaves
                    ]);
              }
              $role_title =auth()->user()->roles->first()->title;
              if ($role_title == 'Admin' || $role_title == 'HR'){
                  $totalEmpoyees = Employee::whereCompanyId(Auth::user()->company_id)->where('is_active',1)->count();
                  $todayDate = Carbon::now()->toDateString();
                  $totalLeaves = LeaveApplication::whereCompanyId(Auth::user()->company_id)->whereStatus(1)->where('start_date','<=', $todayDate)->where('end_date','>=', $todayDate)->count();
                  $totalPresents = Attendance::where('date','=',$todayDate)->count();
                  $allEmpoyees = Employee::whereCompanyId(Auth::user()->company_id)->where('is_active',1)->get();
                  $todayAttendance = Attendance::where('date','=',$todayDate)->get();
                  $absent = [];
                    foreach ($allEmpoyees as $employee){
                       $test = Attendance::where('date','=',$todayDate)->where('employee_id',$employee->id)->first();
                        if(is_null($test)){
                          $absent[] = Employee::findOrFail($employee->id);
                        }
                    }              

                
                  return view('home',compact('role_title','totalEmpoyees','totalLeaves','totalPresents','allEmpoyees','todayAttendance','absent'));

              }else{
                $employeeTotalLeave = LeaveApplication::where('employee_id',Auth::user()->employee_id)->whereStatus(1)->count();
                $employeeAdvancedSalary = SalaryAdvance::where('employee_id',Auth::user()->employee_id)->whereStatus(1)->where('paid_status',0)->sum('amount');
                $employeeLoan = LoanApplication::where('employee_id',Auth::user()->employee_id)->whereStatus(1)->sum('amount');
                return view('home',compact('role_title','employeeTotalLeave','employeeAdvancedSalary','employeeLoan'));
              }      
          
        
    }
}
