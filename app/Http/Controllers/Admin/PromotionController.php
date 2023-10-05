<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Designation;
use App\Models\Grade;
use App\Models\PromotionHistory;
use App\Models\Rule;
use App\Models\SalaryAllowance;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Department;
use App\Models\EmployeeSalary;
use App\Models\SalaryIncrement;
use App\Models\SubCompany;
use Carbon\Carbon;
use Auth;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $promotionHistoryList  = PromotionHistory::orderBy('id','DESC')->paginate(20);
        return view('admin.promotion.index',compact('promotionHistoryList'));
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
        $designation = Designation::get();
        $grades = Grade::get();
        $employees = Employee::where('is_active',1)->get();
        $promotionHistory = null;
        return view('admin.promotion.create', compact('promotionHistory','grades','designation','sub_companies', 'departments', 'employees'));
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

        $percent = $request->percentage;
        if ($percent == null){
            $promotion_amount = $request->previous_amount;
        }else{
            $previous_salary = $request->previous_amount;
            $promotion_amount = ($percent / 100) * $previous_salary;
        }

        $data['promotion_date'] = Carbon::parse($request->promotion_date)->format('Y-m-d');
        $employee_id = $request->employee_id;
        $employees_info = Employee::find($employee_id);
        $promotionHistory = new PromotionHistory();
        $promotionHistory->employee_id = $employee_id;
        $promotionHistory->department_id = $employees_info->department_id;
        $promotionHistory->designation_id = $employees_info->designation_id;
        $promotionHistory->grade_id = $employees_info->grade_id;
        $promotionHistory->previous_amount = $employees_info->salary;
        $promotionHistory->promotion_amount = $promotion_amount;
        if ($employees_info->promotion_date == null){
            $promotionHistory->previous_date =  Carbon::parse($employees_info->joining_date)->format('Y-m-d');
        }else{
            $promotionHistory->previous_date = Carbon::parse($employees_info->promotion_date)->format('Y-m-d');
        }
        $promotionHistory->promotion_date = $data['promotion_date'];
        $promotionHistory->created_by =   Auth::user()->id;
        $promotionHistory->save();

        $promotion_salary = $promotion_amount + $request->previous_amount;
        $ex_salaray = $employees_info->salary;
        if ($ex_salaray != $promotion_salary) {
            $employee_salary = EmployeeSalary::where('employee_id', $employees_info->id)->get();
            foreach ($employee_salary as $val) {
                $val->delete();
            }
            $company_id = \Illuminate\Support\Facades\Auth::user()->company_id;
            $salary_allowances = SalaryAllowance::where('company_id', $company_id)->get();
            if (count($salary_allowances) > 0) {
                foreach ($salary_allowances as $salary_allowance) {
                    $percent = $salary_allowance->percentage;
                    $percentage_salary = ($percent / 100) * $promotion_salary;
                    $employee_salary = new EmployeeSalary;
                    $employee_salary->employee_id = $employees_info->id;
                    $employee_salary->salary_allowance_id = $salary_allowance->id;
                    $employee_salary->salary = $percentage_salary;
                    $employee_salary->save();
                }

            }
        }
        $data['salary'] = $promotion_salary;
        $employees_info->update($data);
        return redirect()->route('admin.promotion.index')->with('message', 'Employee Promoted Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $promotionData  = PromotionHistory::where('id',$id)->first();
        $promotion_history  = PromotionHistory::where('employee_id',$promotionData->employee_id)->get();
        return view('admin.promotion.show', compact('promotionData','promotion_history'));
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

    public function promotionEmployeeSearch( Request $request)
    {
        $data = $request->all();
        $sub_companies = SubCompany::get();
        $departments = Department::get();
        $designation = Designation::get();
        $grades = Grade::get();
        $employees = Employee::where('is_active',1)->get();
        $promotion_rules = Rule::where('type','like','%'.'promotion'.'%')->first();
        if ($promotion_rules == null){
            return redirect()->route('admin.promotion.index')->with('error','Oops ! Please Setup a Rule First !.');
        }
        $promtion_month = $promotion_rules->period;
        $promotionDate = Carbon::parse(Carbon::now()->subMonths($promtion_month))->format('Y-m-d');
        $checkEmployee = Employee::find($request->employee_id);
        if ($checkEmployee->promotion_date == null){
            $promotionHistory = Employee::where('is_active',1)->where('id',$request->employee_id)->where('joining_date','<=',$promotionDate)->first();
        }else{
            $promotionHistory = Employee::where('is_active',1)->where('id',$request->employee_id)->where('promotion_date','<=',$promotionDate)->first();
        }
        if ($promotionHistory == null){
            return redirect()->route('admin.promotion.index')->with('error','Oops ! Not Eligible for Promotion.');
        }else{
            return view('admin.promotion.create', compact('grades','designation','promotionHistory','sub_companies', 'departments', 'employees'));
        }


    }
}
