<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Employee;
use App\Models\Rule;
use App\Models\SalaryAdvance;
use App\Models\SubCompany;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;
use PDF;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class SalaryAdvanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('salary_advance_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $role_title =auth()->user()->roles->first()->title;
        $employee_id = Auth::user()->employee_id;
        if ($role_title == 'Employee') {
            $salaryAdvance_list = SalaryAdvance::with([ 'company', 'employee', 'subcompany'])->where('employee_id',$employee_id)->orderBy('id','DESC')->paginate(20);
        }else{
            $salaryAdvance_list = SalaryAdvance::with([ 'company', 'employee', 'subcompany'])->orderBy('id','DESC')->paginate(20);
        }
        return view('admin.salaryAdvance.index',compact('salaryAdvance_list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('salary_advance_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $company_id =   Auth::user()->company_id;
        $employee_id =   Auth::user()->employee_id;
        $sub_companies = SubCompany::where('company_id',$company_id)->pluck('sub_company_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $companies = Company::where('id',$company_id)->pluck('comp_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $auth_company_id = Auth::user()->company_id;
        $role_title =auth()->user()->roles->first()->title;
        if ($role_title == 'Employee'){
            $user_employees = Employee::where('is_active',1)->where('id',$employee_id)->get();
        }else{
            $user_employees = Employee::join('users','employees.id','=','users.employee_id')
                ->where('users.company_id',$auth_company_id)
                ->where('employees.is_active',1)
                ->select('employees.*')->get();
        }

        return view('admin.salaryAdvance.create', compact('role_title','user_employees','sub_companies','companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sAdvance_rules = Rule::where('type','like','%'.'salaryAdvance'.'%')->first();
        if ($sAdvance_rules == null){
            return redirect()->route('admin.salary-advance.index')->with('error','Oops ! Please Setup a Rule First !.');
        }

        $sAdvancePeriod_month = $sAdvance_rules->period;
        $oneYearAgoDate = Carbon::parse(Carbon::now()->subMonths($sAdvancePeriod_month))->format('Y-m-d');
        $checkEmployee = Employee::where('is_active',1)->where('joining_date','<=',$oneYearAgoDate)->where('id',$request->employee_id)->first();
          $checkPreviousAdvance = SalaryAdvance::where('employee_id',$request->employee_id)->where('paid_status',0)->get();
            if($checkEmployee == null){
                return redirect()->route('admin.salary-advance.index')->with('error','Oops ! Not Eligible for Salary Advance.');
            }else if(count($checkPreviousAdvance)>0){
                 return redirect()->route('admin.salary-advance.index')->with('error','Not yet paid! Previous advance');
          }else{
            $data = $request->all();
            $data['created_by'] = Auth::user()->id;
            $data['sd_date'] = Carbon::parse($request->sd_date)->format('Y-m-d');
            SalaryAdvance::create($data);
             return redirect()->route('admin.salary-advance.index')->with('message','successfully applied');
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
        abort_if(Gate::denies('salary_advance_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $role_title =auth()->user()->roles->first()->title;
        $salaryAdvance = SalaryAdvance::with([ 'company', 'employee', 'subcompany','user'])->where('id',$id)->first();
        $salaryAdvanceHistory = SalaryAdvance::with([ 'company', 'employee', 'subcompany','user'])->where('employee_id',$salaryAdvance->employee_id)->where('id','!=',$id)->get();
        return view('admin.salaryAdvance.show', compact('role_title','salaryAdvanceHistory','salaryAdvance'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(Gate::denies('salary_advance_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $salaryAdvance = SalaryAdvance::find($id);
        $company_id =   Auth::user()->company_id;
        $employee_id =   Auth::user()->employee_id;
        $sub_companies = SubCompany::where('company_id',$company_id)->pluck('sub_company_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $companies = Company::where('id',$company_id)->pluck('comp_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $auth_company_id = Auth::user()->company_id;
        $role_title =auth()->user()->roles->first()->title;
        if ($role_title == 'Employee'){
            $user_employees = Employee::where('is_active',1)->where('id',$employee_id)->get();
        }else{
            $user_employees = Employee::join('users','employees.id','=','users.employee_id')
                ->where('users.company_id',$auth_company_id)
                ->where('employees.is_active',1)
                ->select('employees.*')->get();
        }


        return view('admin.salaryAdvance.edit', compact('salaryAdvance','role_title','user_employees','sub_companies','companies'));
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
        $salaryAdvance = SalaryAdvance::find($id);
        $data = $request->all();
        $data['created_by'] = Auth::user()->id;
        $data['sd_date'] = Carbon::parse($request->sd_date)->format('Y-m-d');
        $salaryAdvance->update($data);
        return redirect()->route('admin.salary-advance.index')->with('message','Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('salary_advance_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $salaryAdvance = SalaryAdvance::find($id);
        $salaryAdvance->delete();
        return redirect()->route('admin.salary-advance.index');
    }

    public function advanceApproved($id)
    {
        $salaryAdvance= SalaryAdvance::find($id);
        $salaryAdvance->status = 1 ;
        $salaryAdvance->save();
        return redirect()->route('admin.salary-advance.index')->with('message','Approved Successfully');
    }

    public function advanceReject($id)
    {
        $salaryAdvance = SalaryAdvance::find($id);
        $salaryAdvance->status = 2 ;
        $salaryAdvance->save();
        return redirect()->route('admin.salary-advance.index')->with('message','Rejected Successfully');
    }

    public function advanceCancel($id)
    {
        $salaryAdvance = SalaryAdvance::find($id);
        $salaryAdvance->delete();
        return redirect()->route('admin.salary-advance.index')->with('message','Cancel Successfully');
    }



}
