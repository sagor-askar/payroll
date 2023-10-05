<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProvidentFund;
use App\Models\ProvidentLoan;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Department;
use App\Models\LoanApplication;
use App\Models\LoanApplicationLog;
use App\Models\Role;
use App\Models\Rule;
use App\Models\Settings;
use App\Models\User;
use Carbon\Carbon;
use Auth;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class ProvidentLoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role_title =auth()->user()->roles->first()->title;
        if ($role_title == 'Employee') {
            $employee_id = Auth::user()->employee_id;
            $provident_loans = ProvidentLoan::with(['employee','permitted_employee'])->where('employee_id',$employee_id)->orderBy('id','DESC')->paginate(20);
        }elseif($role_title == 'HR'){
            $employee_id = Auth::user()->employee_id;
            $provident_loans = ProvidentLoan::orderBy('id','DESC')->with([ 'employee', 'permitted_employee'])->where('permitted_id',$employee_id)->paginate(20);
        }else{
            $provident_loans = ProvidentLoan::orderBy('id','DESC')->with(['employee', 'permitted_employee'])->paginate(20);
        }
        return view('admin.providentLoan.index',compact('provident_loans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
        return view('admin.providentLoan.create', compact('approved_employees','role_title','employees'));
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
        $employee_id = $request->employee_id;
        $providentLoanCheck = ProvidentLoan::where('employee_id',$employee_id)->where('paid_status','!=',1)->latest()->first();
        if ($providentLoanCheck){
            return redirect()->route('admin.provident_loan.index')->with('error','Oops ! Not Eligible for Provident Loan.');
        }
        $providentFund = ProvidentFund::where('employee_id',$employee_id)->get()->sum('pf_amount');
        if($request->amount <= $providentFund ){
            $data['created_by'] = Auth::user()->id;
            $data['apply_date'] = Carbon::parse($request->apply_date)->format('Y-m-d');
            $data['adjustment_date'] = Carbon::parse($request->adjustment_date)->format('Y-m-d');
            $data['due_amount'] = $request->amount;
            ProvidentLoan::create($data);
            return redirect()->route('admin.provident_loan.index')->with('message','Applied Successfully');
        }else{
            return redirect()->route('admin.provident_loan.index')->with('error','Oops ! Not Eligible for Provident Loan.');
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
        $role_title =auth()->user()->roles->first()->title;
        $providentLoan = ProvidentLoan::find($id);
        $providentLoan_history  = ProvidentLoan::with(['permitted_employee','employee'])->where('employee_id',$providentLoan->employee_id)->where('id','!=',$id)->get();
        return view('admin.providentLoan.show', compact('providentLoan_history','role_title','providentLoan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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
        $providentLoan = ProvidentLoan::find($id);
        return view('admin.providentLoan.edit', compact('providentLoan','approved_employees','role_title','employees'));
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
        $employee_id = $request->employee_id;

        $providentFund = ProvidentFund::where('employee_id',$employee_id)->get()->sum('pf_amount');
        if($request->amount <= $providentFund){
            $providentLoan = ProvidentLoan::find($id);
            $data['created_by'] = Auth::user()->id;
            $data['updated_by'] = Auth::user()->id;
            $data['apply_date'] = Carbon::parse($request->apply_date)->format('Y-m-d');
            $data['adjustment_date'] = Carbon::parse($request->adjustment_date)->format('Y-m-d');
            $providentLoan->update($data);
            return redirect()->route('admin.provident_loan.index')->with('message','Successfully updated');
        }else{
            return redirect()->route('admin.provident_loan.index')->with('error','Oops! Please check the Amount');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $providentLoan = ProvidentLoan::find($id);
        $providentLoan->delete();
        return redirect()->route('admin.provident_loan.index');
    }

    public function loanApproved($id)
    {
        $permitted_by = Auth::user()->id;
        $approved_date = Carbon::now();
        $approved_date=  Carbon::parse($approved_date)->format('Y-m-d');
        $providentLoan= ProvidentLoan::find($id);
        $providentLoan->permitted_id = $permitted_by;
        $providentLoan->approved_date = $approved_date;
        $providentLoan->updated_by = $permitted_by;
        $providentLoan->status = 1 ;
        $providentLoan->active_status = 1 ;
        $providentLoan->save();
        return redirect()->route('admin.provident_loan.index')->with('message','Approved Successfully');
    }

    public function loanReject($id)
    {
        $providentLoan = ProvidentLoan::find($id);
        $providentLoan->status = 2 ;
        $providentLoan->save();
        return redirect()->route('admin.provident_loan.index')>with('message','Rejected Successfully');
    }
}
