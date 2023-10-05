<?php

namespace App\Http\Controllers\Admin;

use App\Models\Employee;
use App\Models\Department;
use App\Models\EmployeeSalary;
use App\Models\Rule;
use App\Models\SalaryIncrement;
use App\Models\SubCompany;
use Carbon\Carbon;
use Auth;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class IncrementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $incrementSalary  = SalaryIncrement::with(['employee','user'])->orderBy('id','DESC')->paginate(20);
        return view('admin.increment.index',compact('incrementSalary'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sub_companies = SubCompany::get();
        $departments = Department::get();
        $promotion_rules = Rule::where('type','like','%'.'increment'.'%')->first();
        if ($promotion_rules == null){
            return redirect()->route('admin.increment.index')->with('error','Oops ! Please Setup a Rule First !.');
        }
        $incrementPeriod_month = $promotion_rules->period;
        $oneYearAgoDate = Carbon::parse(Carbon::now()->subMonths($incrementPeriod_month))->format('Y-m-d');
        $employees = Employee::where('is_active',1)->where('joining_date','<=',$oneYearAgoDate)->get();
        return view('admin.increment.create', compact('sub_companies', 'departments', 'employees'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $data =  $request->all();
         $increment_salary =  $request->increment_salary;
         $data['salary'] =  $request->increment_salary;
        $data['increment_amount'] = $increment_salary -  $request->gross_salary;
        $data['increment_date'] = Carbon::parse($request->date)->format('Y-m-d');
        $data['created_by'] = Auth::user()->id;
        $checkDate = Carbon::parse($request->date)->format('Y');
        $start_date = $checkDate.'-01-01';
        $end_date = $checkDate.'-12-31';
        $increment_employeeData = SalaryIncrement::where('employee_id',$request->employee_id)->where('increment_date','>=', $start_date)->where('increment_date','<=', $end_date)->first();
       if ($increment_employeeData == null) {
           $employee_salarys = EmployeeSalary::where('employee_id', $request->employee_id)->get();
           foreach ($employee_salarys as $key => $employee_salary) {
               $percent = $employee_salary->salary_allowance->percentage;
               $percentage_salary = ($percent / 100) * $increment_salary;
               $employee_salary->salary = $percentage_salary;
               $employee_salary->update();
           }
           $employee = Employee::find($request->employee_id);
           $employee->salary = $increment_salary;
           $employee->update();
           SalaryIncrement::create($data);
           return redirect()->route('admin.increment.index')->with('message', 'Successfully Increment Generated !');
       }else{
           return redirect()->route('admin.increment.index')->with('error', 'Oops ! Already Exits.');
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
        //
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
}
