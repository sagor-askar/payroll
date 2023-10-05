<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Education;
use App\Models\Employee;
use App\Models\EmployeeSalary;
use App\Models\LoanApplication;
use App\Models\SalaryAdvance;
use App\Models\User;
use App\Models\UserTermination;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TerminationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userterminations = UserTermination::get();
        return view('admin.user_termination.index', compact('userterminations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employees = Employee::where('is_active',1)->get();
        return view('admin.user_termination.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try{
            $data = $request->all();
            $data['notice_date'] = Carbon::parse($request->notice_date)->format('Y-m-d');
            $data['terminatation_date'] = Carbon::parse($request->terminatation_date)->format('Y-m-d');
            $employee_id = $request->employee_id;
            $loaninfo =  LoanApplication::where('employee_id',$employee_id)->where('paid_status','!=',1)->where('due_amount','>',0)->latest()->first();
            $salaryAdvance =  SalaryAdvance::where('employee_id',$employee_id)->where('paid_status','!=',1)->latest()->first();

            if ($loaninfo){
                return redirect()->route('admin.terminations.index')->with("error","This Employee has loan , You can't Terminate him now!");
            }
            if ($salaryAdvance){
                return redirect()->route('admin.terminations.index')->with("error","This Employee has advance Salary , You can't Terminate him now!");
            }
            UserTermination::create($data);
            $employee =  Employee::find($employee_id);
            $employee->is_active = 0 ;
            $employee->save();
            $user =  User::where('employee_id',$employee_id)->first();
            $user->delete();
            DB::commit();
            return redirect()->route('admin.terminations.index')->with('message','User Termination Created Successfully');

        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->route('admin.terminations.index')->with('error', $e->getMessage());
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
        $userTermination = UserTermination::find($id);
        $employee = Employee::find($userTermination->employee_id);
        $education = Education::where('employee_id',$employee->id)->get();
        $employee_salaries = EmployeeSalary::where('employee_id',$employee->id)->get();

        return view('admin.user_termination.show', compact('employee','education','employee_salaries'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employees = Employee::where('is_active',1)->get();
        $userTermination = UserTermination::find($id);
        return view('admin.user_termination.edit', compact('employees','userTermination'));
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
        $userTermination = UserTermination::find($id);
        $data = $request->all();
        $data['notice_date'] = Carbon::parse($request->notice_date)->format('Y-m-d');
        $data['terminatation_date'] = Carbon::parse($request->terminatation_date)->format('Y-m-d');
        $userTermination->update($data);
        return redirect()->route('admin.terminations.index')->with('message','User Termination Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $userTermination = UserTermination::find($id);
        $userTermination->delete();
        return redirect()->route('admin.terminations.index')->with('message','Data Deleted Successfully !');
    }

    public function changeStatus($id)
    {

        $userTermination = UserTermination::find($id);
        if ($userTermination->is_active == 1){
            $userTermination->is_active = 0;
            $userTermination->save();
            $employee =  Employee::find($userTermination->employee_id);
            $employee->is_active = 1 ;
            $employee->save();
             $userbvb = User::withTrashed()->where('employee_id',$userTermination->employee_id)->first()->restore();

            return redirect()->route('admin.terminations.index')->with('message','Termination Status Change Successfully !');
        }

        if ($userTermination->is_active == 0){
            $userTermination->is_active = 1;
            $userTermination->save();
            $employee =  Employee::find($userTermination->employee_id);
            $employee->is_active = 0 ;
            $employee->save();
            $userfdsf =  User::where('employee_id',$userTermination->employee_id)->first();
            $userfdsf->delete();
            return redirect()->route('admin.terminations.index')->with('message','Termination Status Change Successfully !');
        }
    }
}
