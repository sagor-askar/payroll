<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Department;
use App\Models\LoanApplication;
use App\Models\LoanApplicationLog;
use App\Models\Role;
use App\Models\Rule;
use App\Models\Settings;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('loan_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $role_title =auth()->user()->roles->first()->title;
        if ($role_title == 'Employee') {
            $employee_id = Auth::user()->employee_id;
            $loanApplication = LoanApplication::with(['employee','permitted_employee'])->where('employee_id',$employee_id)->orderBy('id','DESC')->paginate(20);
        }elseif($role_title == 'HR'){
            $employee_id = Auth::user()->employee_id;
            $loanApplication = LoanApplication::orderBy('id','DESC')->with([ 'employee', 'permitted_employee'])->where('permitted_id',$employee_id)->paginate(20);
        }else{
            $loanApplication = LoanApplication::orderBy('id','DESC')->with(['employee', 'permitted_employee'])->paginate(20);
        }
        return view('admin.loanApplication.index',compact('loanApplication'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('loan_access_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employee_id =   Auth::user()->employee_id;
        $role_title =auth()->user()->roles->first()->title;
        if ($role_title == 'Employee'){
            $employees = Employee::where('is_active',1)->where('id',$employee_id)->get();
        }else{
            $employees = Employee::where('is_active',1)->get();
        }
        $roles = Role::where('title','=','HR')->first();
        $users = User::where('role_id',$roles->id)->get();
        foreach ($users as $val){
            $emp_id[] = $val->employee_id;
        }
        $approved_employees = Employee::where('is_active',1)->whereIn('id',$emp_id)->get();
        return view('admin.loanApplication.create', compact('approved_employees','role_title','employees'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $loan_rules = Rule::where('type','like','%'.'loan'.'%')->first();
        if ($loan_rules == null){
            return redirect()->route('admin.loan.index')->with('error','Oops ! Please Setup a Rule First !.');
        }
        $loanPeriod_month = $loan_rules->period;
        $oneYearAgoDate = Carbon::parse(Carbon::now()->subMonths($loanPeriod_month))->format('Y-m-d');
        $checkEmployee = Employee::where('is_active',1)->where('joining_date','<=',$oneYearAgoDate)->where('id',$request->employee_id)->first();
        if($checkEmployee == null){
            return redirect()->route('admin.loan.index')->with('error','Oops ! Not Eligible for Loan.');
        }
        if($request->amount < 0 || $request->installment_amount < 0){
            return redirect()->route('admin.loan.index')->with('error','Ops!Must be positive value');
        }
        $data = $request->all();
        $data['created_by'] = Auth::user()->id;
        $data['apply_date'] = Carbon::parse($request->apply_date)->format('Y-m-d');
        $data['adjustment_date'] = Carbon::parse($request->adjustment_date)->format('Y-m-d');
        $data['due_amount'] = $request->amount;
        LoanApplication::create($data);
        return redirect()->route('admin.loan.index')->with('message','Applied Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort_if(Gate::denies('loan_access_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $role_title =auth()->user()->roles->first()->title;
        $loanApplication = LoanApplication::find($id);
        $loanApplication_history  = LoanApplication::with(['permitted_employee','employee'])->where('employee_id',$loanApplication->employee_id)->where('id','!=',$id)->get();
        return view('admin.loanApplication.show', compact('loanApplication_history','role_title','loanApplication'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(Gate::denies('loan_access_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employee_id =   Auth::user()->employee_id;
        $role_title =auth()->user()->roles->first()->title;
        if ($role_title == 'Employee'){
            $employees = Employee::where('is_active',1)->where('id',$employee_id)->get();
        }else{
            $employees = Employee::where('is_active',1)->get();
        }
        $roles = Role::where('title','=','HR')->first();
        $users = User::where('role_id',$roles->id)->get();
        foreach ($users as $val){
            $emp_id[] = $val->employee_id;
        }
        $approved_employees = Employee::where('is_active',1)->whereIn('id',$emp_id)->get();
        $loanApplication = LoanApplication::find($id);
        return view('admin.loanApplication.edit', compact('loanApplication','approved_employees','role_title','employees'));
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
        $loanApplication = LoanApplication::find($id);
        $data = $request->all();
        $data['created_by'] = Auth::user()->id;
        $data['updated_by'] = Auth::user()->id;
        $data['apply_date'] = Carbon::parse($request->apply_date)->format('Y-m-d');
        $data['adjustment_date'] = Carbon::parse($request->adjustment_date)->format('Y-m-d');
        $loanApplication->update($data);
        return redirect()->route('admin.loan.index')->with('message','Successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('loan_access_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $loanApplication = LoanApplication::find($id);
        $loanApplication->delete();
        return redirect()->route('admin.loan.index');
    }

    public function loanApproved($id)
    {
        $permitted_by = Auth::user()->id;

        $approved_date = Carbon::now();
        $approved_date=  Carbon::parse($approved_date)->format('Y-m-d');

        $loanApplication= LoanApplication::find($id);
        $loanApplication->permitted_id = $permitted_by;
        $loanApplication->approved_date = $approved_date;
        $loanApplication->updated_by = $permitted_by;
        $loanApplication->status = 1 ;
        $loanApplication->save();
        return redirect()->route('admin.loan.index')->with('message','Approved Successfully');
    }

    public function loanCancel($id)
    {
        $loanApplication = LoanApplication::find($id);
        $loanApplication->delete();
        return redirect()->route('admin.loan.index')>with('message','Cancel Successfully');
    }

    public function loanReject($id)
    {
        $loanApplication = LoanApplication::find($id);
        $loanApplication->status = 2 ;
        $loanApplication->save();
        return redirect()->route('admin.loan.index')>with('message','Rejected Successfully');
    }

    public function loanReport()
    {
        $departments = Department::pluck('department_name', 'id');
        $employees = Employee::where('is_active',1)->get();
        $loanReportsHistory = [];
        return view('admin.reports.loan_report', compact('departments', 'employees', 'loanReportsHistory'));
    }

    public function loanReportSearch(Request $request)
    {
        $employee_id  = $request->employee_id;
        $date = Carbon::parse($request->date)->format('Y-m-d');
        $query = new LoanApplication();
        if($employee_id)
        {
            $query =  $query->where('employee_id',$employee_id);
        }
        if($request->date != null)
        {
            $query =  $query->where('approved_date',$date);
        }
        $loanReportsHistory = $query->where('status', 1)->get();

        $setting = Settings::first();
        return view ('admin.reports.loan_table',[
            'loanReportsHistory' => $loanReportsHistory,
            'setting'          => $setting,
        ]);
    }

    public function getLoanHistory(Request $request)
    {
         $loan_id =  $request->id;
        $data['loanHistory'] =  LoanApplicationLog::where('loan_application_id',$loan_id)->get();
        return $data['loanHistory'];
    }
}
