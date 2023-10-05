<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\AdditionalAllowanceSetup;
use App\Models\AdditionalAllowanceDistribution;
use App\Models\AdditionalDeductionSetup;
use App\Models\AdditionalDeductionPenalty;
use App\Models\Attendance;
use App\Models\EmployeeSalary;
use App\Models\LateDeductionRules;
use App\Models\LoanApplication;
use App\Models\ProvidentLoan;
use App\Models\ProvidentLoanLog;
use App\Models\SalaryAdvance;
use App\Models\SalaryAllowance;
use App\Models\SalaryGenerate;
use App\Models\Settings;
use App\Models\Rule;
use Carbon\Carbon;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;
use PDF;
use App\Models\Employee;
use App\Models\Department;
use App\Models\SubCompany;
use App\Models\Holiday;
use App\Models\LoanApplicationLog;
use App\Models\Overtime;
use App\Models\ProvidentFund;
use App\Models\ProvidentfundSetting;
use App\Models\WeeklyHoliday;
use DateTime;
use Illuminate\Support\Facades\Storage;
use DB;

class payrollController extends Controller
{
    public function salaryAdvance()
    {
        return view('admin.payroll.salary-advance');
    }


    public function salaryGenerateList()
    {
        $date = date('Y-m');
        $start_date = $date.'-'.'01';
        $end_date = $date.'-'.'31';
        $role_title =auth()->user()->roles->first()->title;
        if ($role_title == 'Employee') {
            $employee_id = Auth::user()->employee_id;
            $salary_generate_history = SalaryGenerate::where('employee_id',$employee_id)->where('generate_date','>=',$start_date)->where('generate_date','<=',$end_date)->paginate(20);
        }else{
            $salary_generate_history = SalaryGenerate::where('generate_date','>=',$start_date)->where('generate_date','<=',$end_date)->paginate(20);
        }
        return view('admin.payroll.salary-generate-list',compact('salary_generate_history'));
    }

    public function salaryGenerate()
    {
        $sub_companies = SubCompany::pluck('sub_company_name', 'id');
        $departments = Department::pluck('department_name', 'id');
        $employees = Employee::where('is_active',1)->get();
        $validEmployees = [];
        $start_date = ' ';
        $end_date = ' ';
        return view('admin.payroll.salary-generate', compact('end_date','start_date','validEmployees','sub_companies', 'departments', 'employees'));
    }


    public function salaryGenerateSearch( Request $request)
    {
        $employee_id = $request->employee_id;
        $year = $request->year;
        $month = $request->month;
        $start_date = $year.'-'.$month.'-'.'01';
        $end_date = $year.'-'.$month.'-'.'31';

        $rules = Rule::first();
        $system_out = $rules->end_time;
        $system_out = strtotime($system_out);

        if ($employee_id == null){
            $employees =  Employee::where('is_active',1)->where('is_attendence',1)->get();
            foreach ($employees as $val){
                $emp_id[] = $val->id;
            }
           $ot_Attendance = Attendance::whereIn('employee_id',$emp_id)->where('date','>=',$start_date)->where('date','<=',$end_date)->where('early_leaving',null)->get();


           foreach ($ot_Attendance as $ot_val){
               $ot_employee_id = $ot_val->employee_id;
               $date = Carbon::parse($ot_val->date)->format('Y-m-d');
               $exit_time = strtotime($ot_val->clock_out);
               $ot_diff = $exit_time - $system_out;
               $totalHour=(int) (date('H', $ot_diff) + (date('i', $ot_diff)/60));
               $ot_Attendance = Overtime::where('employee_id',$ot_employee_id)->where('ot_date',$date)->where('status',1)->first();
              if($ot_Attendance){
                if($ot_Attendance->ot_time > $totalHour){
                    $totalHour = $totalHour;
                }else{
                    $totalHour = $ot_Attendance->ot_time;
                }
               $ot_Attendance->working_hour = $totalHour;
               $ot_Attendance->ot_salary = ($totalHour * $ot_Attendance->hour_rate);
               $ot_Attendance->update();
              }
            }
          $employees =  Employee::where('is_active',1)->get();
          foreach ($employees as $val){
              $emp_id[] = $val->id;
          }
          $salary_generate_history = SalaryGenerate::whereIn('employee_id',$emp_id)->where('generate_date','>=',$start_date)->where('generate_date','<=',$end_date)->get();
         if (count($salary_generate_history) > 0){
             foreach ($salary_generate_history as $has_employee){
                 $has_emp_id[] = $has_employee->employee_id;
             }
           $validEmployees =  Employee::where('is_active',1)->whereNotIn('id',$has_emp_id)->get();
             if ( !count($validEmployees) > 0){
                 return redirect()->route('admin.payroll.salary-generate')->with('error','Already Salary Generated ! ');
             }

         }else{
             $validEmployees =  Employee::where('is_active',1)->get();
         }

          }else {
           $ot_Attendance = Attendance::where('employee_id',$employee_id)->where('date','>=',$start_date)->where('date','<=',$end_date)->where('early_leaving',null)->get();
           foreach ($ot_Attendance as $ot_val){
               $ot_employee_id = $ot_val->employee_id;
               $date = Carbon::parse($ot_val->date)->format('Y-m-d');
               $exit_time = strtotime($ot_val->clock_out);
               $ot_diff = $exit_time - $system_out;
               $totalHour=(int) (date('H', $ot_diff) + (date('i', $ot_diff)/60));
               $ot_Attendance = Overtime::where('employee_id',$ot_employee_id)->where('ot_date',$date)->where('status',1)->first();
              if($ot_Attendance){
                if($ot_Attendance->ot_time > $totalHour){
                    $totalHour = $totalHour;
                }else{
                    $totalHour = $ot_Attendance->ot_time;
                }
               $ot_Attendance->working_hour = $totalHour;
               $ot_Attendance->ot_salary = ($totalHour * $ot_Attendance->hour_rate);
               $ot_Attendance->update();
              }
            }

            $salary_generate_history = SalaryGenerate::where('employee_id',$employee_id)->where('generate_date', '>=', $start_date)->where('generate_date', '<=', $end_date)->get();
            if (count($salary_generate_history) > 0) {
                return redirect()->route('admin.payroll.salary-generate')->with('error','Already Salary Generated ! ');
            }else{
                $validEmployees =  Employee::where('is_active',1)->where('id',$employee_id)->get();
            }
        }
        $sub_companies = SubCompany::pluck('sub_company_name', 'id');
        $departments = Department::pluck('department_name', 'id');
        $employees = Employee::where('is_active',1)->get();
        // WORKING DAYS COUNT START
        $numberOfDaysInMonth = Carbon::now()->daysInMonth;
        $weeksIhisMonth      = $this->weeksInMonth($numberOfDaysInMonth);
        $leaveDays           = WeeklyHoliday::sum('weeklyleave');
        $monthHoliday        = Holiday::whereMonth('from_holiday','=',Carbon::now()->month)->sum('number_of_days');
        $totalHoliday        = (intval($weeksIhisMonth)) * (intval($leaveDays));
        $workingDays         = $numberOfDaysInMonth - $totalHoliday - $monthHoliday;
        // WORKING DAYS COUNT END
        return view('admin.payroll.salary-generate', compact('end_date','start_date','validEmployees','sub_companies', 'departments', 'employees','workingDays'));
    }


    public function salaryGenerateStore( Request $request)
    {
        $created_by = Auth::user()->id;
        $generate_date= date('Y-m-d');
        $employees =  $request->employee_id;

        for ( $i = 0; $i < count($employees); $i++) {
            $salaryGenerate= new SalaryGenerate();
            $salaryGenerate->employee_id = $request->employee_id[$i];
            $salaryGenerate->basic_amount = $request->basic_salary[$i];
            $salaryGenerate->allowance_amount = $request->allowance_amount[$i];
            $salaryGenerate->additional_amount = $request->addtional_allowance_amount[$i];
            $salaryGenerate->ot_salary = $request->ot_salary[$i];
            $salaryGenerate->bonus = $request->bonus[$i];
            $salaryGenerate->gross_salary = $request->gross_salary[$i];
            $salaryGenerate->loan_amount = $request->loan_amount[$i];
            $salaryGenerate->pf_loan_amount = $request->pf_loan_amount[$i];
            $salaryGenerate->advance_amount = $request->advance_amount[$i];
            $salaryGenerate->deduction_amount = $request->addtional_deduction_amount[$i];
            $salaryGenerate->late_deduction_amount = $request->total_late_deduction_amount[$i];
            $salaryGenerate->total_deduction = $request->all_deduction_amount[$i];
            $salaryGenerate->net_salary = $request->net_salary[$i];
            $salaryGenerate->generate_date = $generate_date;
            $salaryGenerate->created_by = $created_by;
            $salaryGenerate->save();
        }
        return redirect()->route('admin.payroll.salary-generate')->with('message','Successfully Salary Generated !');
    }

    public function salaryGenerateShow($id)
    {

        $salary_generate_history =  SalaryGenerate::find($id);
        $year = Carbon::parse($salary_generate_history->generate_date)->format('Y');
        $month = Carbon::parse($salary_generate_history->generate_date)->format('m');
        $start_date = $year.'-'.$month.'-'.'01';
        $end_date = $year.'-'.$month.'-'.'31';

        $employee_id = $salary_generate_history->employee_id;
        $salaryAllowance = SalaryAllowance::where('allowance_name','like','%'.'basic'.'%')->first();
        $basicSalaryInfo = EmployeeSalary::where('employee_id',$employee_id)->where('salary_allowance_id',$salaryAllowance->id)->first();
        $basic =  $basicSalaryInfo->salary;

        $allowanceAmountDetails = EmployeeSalary::where('employee_id',$employee_id)->whereNot('salary_allowance_id',$salaryAllowance->id)->get();
        $allowanceAmount = $allowanceAmountDetails->sum('salary');

        $addtionalAllowanceAmountDetails =  AdditionalAllowanceDistribution::where('employee_id',$employee_id)->where('allowance_date','>=',$start_date)->where('allowance_date','<=',$end_date)->get();
        $addtionalAllowanceAmount = $addtionalAllowanceAmountDetails->sum('allowance');
        $ot_salary =  $salary_generate_history->ot_salary;
        $bonus =  $salary_generate_history->bonus;
        $grossSalary = $basicSalaryInfo->salary + $allowanceAmount+$addtionalAllowanceAmount + $ot_salary + $bonus;
        // loan amount
        $loanAmount =  $salary_generate_history->loan_amount;

        // PF loan amount
        $pf_loanAmount =  $salary_generate_history->pf_loan_amount;

        $advanceAmountDetails =  SalaryAdvance::where('employee_id',$employee_id)->where('paid_status',0)->where('status',1)->where('sd_date','>=',$start_date)->where('sd_date','<=',$end_date)->get();
        //$advanceAmount = $advanceAmountDetails->sum('amount');
        $advanceAmount = $salary_generate_history->advance_amount;

        $addtionalDeductionAmountDetails =  AdditionalDeductionPenalty::where('employee_id',$employee_id)->where('deduction_date','>=',$start_date)->where('deduction_date','<=',$end_date)->get();
        $addtionalDeductionAmount = $addtionalDeductionAmountDetails->sum('deduction');

        $employee_details_info =  Employee::find($employee_id);
        if ($employee_details_info){
            $provident_found = $employee_details_info->provident_fund;
        }else{
            $provident_found = 0;
        }

        $lateRules =  LateDeductionRules::where('status',1)->first();
        $lateAttendances=  Attendance::where('employee_id',$employee_id)->where('date','>=',$start_date)->where('date','<=',$end_date)->get();
         $present_workingDays = count($lateAttendances);

        // WORKING DAYS COUNT START
         $numberOfDaysInMonth = Carbon::now()->daysInMonth;
         $weeksIhisMonth      = $this->weeksInMonth($numberOfDaysInMonth);
         $leaveDays           = WeeklyHoliday::sum('weeklyleave');
         $monthHoliday        = Holiday::whereMonth('from_holiday','=',Carbon::now()->month)->sum('number_of_days');
         $totalHoliday        = (intval($weeksIhisMonth)) * (intval($leaveDays));
         $workingDays         = $numberOfDaysInMonth - $totalHoliday - $monthHoliday;

        // WORKING DAYS COUNT END

        $totalLateAttendaance =  $lateAttendances->where('late','!=',null)->count();
        $lateDays = intval($totalLateAttendaance/($lateRules->late_days));
        $netWorkingDays =  $present_workingDays - $lateDays;
        $salaryAllowancePerDays =  EmployeeSalary::where('employee_id',$employee_id)->where('salary_allowance_id',$lateRules->salary_allowance_id)->first();
        $perDaySalary = $salaryAllowancePerDays->salary /$workingDays;
        $totalLateDeductionAmount = intval($perDaySalary * $lateDays);

        $allDeductionAmount = $pf_loanAmount + $provident_found + $loanAmount + $advanceAmount+$addtionalDeductionAmount+$totalLateDeductionAmount;
        $netSalary = $grossSalary-$allDeductionAmount;
        return view('admin.payroll.show',compact('pf_loanAmount','present_workingDays','bonus','ot_salary','netSalary','allDeductionAmount','totalLateDeductionAmount','addtionalDeductionAmountDetails','advanceAmount','loanAmount','grossSalary','addtionalAllowanceAmountDetails','allowanceAmountDetails','basic','netWorkingDays','salary_generate_history'));
    }

    public function paySlip($id)
    {
        $salary_generate_history =  SalaryGenerate::find($id);
        $year = Carbon::parse($salary_generate_history->generate_date)->format('Y');
        $month = Carbon::parse($salary_generate_history->generate_date)->format('m');
        $start_date = $year.'-'.$month.'-'.'01';
        $end_date = $year.'-'.$month.'-'.'31';

        $employee_id = $salary_generate_history->employee_id;
        $salaryAllowance = SalaryAllowance::where('allowance_name','like','%'.'basic'.'%')->first();
        $basicSalaryInfo = EmployeeSalary::where('employee_id',$employee_id)->where('salary_allowance_id',$salaryAllowance->id)->first();
        $basic =  $basicSalaryInfo->salary;

        $allowanceAmountDetails = EmployeeSalary::where('employee_id',$employee_id)->whereNot('salary_allowance_id',$salaryAllowance->id)->get();
        $allowanceAmount = $allowanceAmountDetails->sum('salary');

        $addtionalAllowanceAmountDetails =  AdditionalAllowanceDistribution::where('employee_id',$employee_id)->where('allowance_date','>=',$start_date)->where('allowance_date','<=',$end_date)->get();
        $addtionalAllowanceAmount = $addtionalAllowanceAmountDetails->sum('allowance');
        $ot_salary =  $salary_generate_history->ot_salary;
        $bonus =  $salary_generate_history->bonus;
        $grossSalary = $basicSalaryInfo->salary + $allowanceAmount+$addtionalAllowanceAmount +$ot_salary + $bonus;

        $loanAmount = $salary_generate_history->loan_amount;
        $pf_loanAmount = $salary_generate_history->pf_loan_amount;

        $advanceAmountDetails =  SalaryAdvance::where('employee_id',$employee_id)->where('paid_status',1)->where('status',1)->where('sd_date','>=',$start_date)->where('sd_date','<=',$end_date)->get();
        //$advanceAmount = $advanceAmountDetails->sum('amount');
        $advanceAmount = $salary_generate_history->advance_amount;
        $addtionalDeductionAmountDetails =  AdditionalDeductionPenalty::where('employee_id',$employee_id)->where('deduction_date','>=',$start_date)->where('deduction_date','<=',$end_date)->get();
        $addtionalDeductionAmount = $addtionalDeductionAmountDetails->sum('deduction');

        $employee_details_info =  Employee::find($employee_id);
        if ($employee_details_info){
            $provident_found = $employee_details_info->provident_fund;
        }else{
            $provident_found = 0;
        }

        $lateRules =  LateDeductionRules::where('status',1)->first();
        $lateAttendances=  Attendance::where('employee_id',$employee_id)->where('date','>=',$start_date)->where('date','<=',$end_date)->get();
         $present_workingDays = count($lateAttendances);
        // WORKING DAYS COUNT START
        $numberOfDaysInMonth = Carbon::now()->daysInMonth;
        $weeksIhisMonth      = $this->weeksInMonth($numberOfDaysInMonth);
        $leaveDays           = WeeklyHoliday::sum('weeklyleave');
        $monthHoliday        = Holiday::whereMonth('from_holiday','=',Carbon::now()->month)->sum('number_of_days');
        $totalHoliday        = (intval($weeksIhisMonth)) * (intval($leaveDays));
        $workingDays         = $numberOfDaysInMonth - $totalHoliday - $monthHoliday;

       // WORKING DAYS COUNT END

        $totalLateAttendaance =  $lateAttendances->where('late','!=',null)->count();
        $lateDays = intval($totalLateAttendaance/($lateRules->late_days));
        $netWorkingDays = $present_workingDays - $lateDays;
        $salaryAllowancePerDays =  EmployeeSalary::where('employee_id',$employee_id)->where('salary_allowance_id',$lateRules->salary_allowance_id)->first();
        $perDaySalary = $salaryAllowancePerDays->salary /$workingDays;
        $totalLateDeductionAmount = intval($perDaySalary * $lateDays);

        $allDeductionAmount = $pf_loanAmount + $provident_found + $loanAmount + $advanceAmount+$addtionalDeductionAmount+$totalLateDeductionAmount;
        $netSalary = $grossSalary-$allDeductionAmount;
        $setting = Settings::first();

        return view('admin.payroll.payslip',compact('pf_loanAmount','present_workingDays','bonus','ot_salary','setting','netSalary','allDeductionAmount','totalLateDeductionAmount','addtionalDeductionAmountDetails','advanceAmount','loanAmount','grossSalary','addtionalAllowanceAmountDetails','allowanceAmountDetails','basic','netWorkingDays','salary_generate_history'));
    }

    public function payslipDetails()
    {
       $salaries = SalaryGenerate::select(DB::raw('DATE_FORMAT(generate_date, "%Y-%m") as month'))
        ->groupBy(DB::raw('DATE_FORMAT(generate_date, "%Y-%m")'))
        ->get();

        return view('admin.payroll.payslipDetails',compact('salaries'));
    }

    public function salaryChart($date)
    {
        $start_date = $date.'-'.'01';
        $end_date = $date.'-'.'31';
        $setting = Settings::first();
        $date= $date;
        $month_name = Carbon::createFromFormat('Y-m', $date);
        $monthName = $month_name->format('F Y');
       
        $salaryChart = SalaryGenerate::where('generate_date','>=',$start_date)->where('generate_date','<=',$end_date)->get();
        return view('admin.payroll.salaryChart', compact('monthName', 'salaryChart', 'setting','date'));
    }

    public function salaryChartPDF($date) 
    {
        $start_date = $date.'-'.'01';
        $end_date = $date.'-'.'31';
        $setting = Settings::first();
        $date = $date;
        $month_name = Carbon::createFromFormat('Y-m', $date);
        $monthName = $month_name->format('F Y');

        $salaryChart = SalaryGenerate::where('generate_date','>=',$start_date)->where('generate_date','<=',$end_date)->get();
        $pdf = PDF::loadview('admin.payroll.salary-chart-pdf', compact('monthName', 'setting','salaryChart'))->setOptions(['defaultFont' => 'sans-serif']);
        
        return $pdf->setPaper('a4')->stream('report.pdf');
    }

    public function bankPayslip($date)
    {
        $start_date = $date.'-'.'01';
        $end_date = $date.'-'.'31';
        $setting = Settings::first();
        $date= $date;
        $month_name = Carbon::createFromFormat('Y-m', $date);
        $monthName = $month_name->format('F Y');

        $salaryChart = SalaryGenerate::where('generate_date','>=',$start_date)->where('generate_date','<=',$end_date)->get();
       
        return view('admin.payroll.bankPayslip', compact('monthName', 'salaryChart', 'setting','date'));
    }

    public function bankPayslipPDF($date)
    {
        $start_date = $date.'-'.'01';
        $end_date = $date.'-'.'31';
        $setting = Settings::first();
        $date = $date;
        $month_name = Carbon::createFromFormat('Y-m', $date);
        $monthName = $month_name->format('F Y');

        $salaryChart = SalaryGenerate::where('generate_date','>=',$start_date)->where('generate_date','<=',$end_date)->get();
        $pdf = PDF::loadview('admin.payroll.bankPayslip-pdf', compact('monthName', 'setting','salaryChart'))->setOptions(['defaultFont' => 'sans-serif']);
        
        return $pdf->setPaper('a4')->stream('report.pdf');
    }

    public function salaryGenerateConfirm($id)
    {
        $salary_generate_history =  SalaryGenerate::find($id);
        $year = Carbon::parse($salary_generate_history->generate_date)->format('Y');
        $month = Carbon::parse($salary_generate_history->generate_date)->format('m');
        $start_date = $year.'-'.$month.'-'.'01';
        $end_date = $year.'-'.$month.'-'.'31';
        $employee_id = $salary_generate_history->employee_id;
        $loanAmount = 0;
        $pf_loanAmount = 0;
        // provident fund start
                $check = ProvidentfundSetting::orderBy('id', 'DESC')->first();
                $employee = Employee::find($salary_generate_history->employee_id);
               if($check!=null){
                   if($check->status == 1 && $check->company_contribution_status == null){
                            $providentFund = new ProvidentFund();
                            $providentFund->employee_id = $salary_generate_history->employee_id;
                            $providentFund->pf_date = $salary_generate_history->generate_date;
                            $providentFund->pf_amount = $employee->provident_fund;
                            $providentFund->save();
                   } else if($check->status == 1 && $check->company_contribution_status == 1){
                            $providentFund = new ProvidentFund();
                            $providentFund->employee_id = $salary_generate_history->employee_id;
                            $providentFund->pf_date = $salary_generate_history->generate_date;
                            $providentFund->pf_amount = $employee->provident_fund;
                            $providentFund->company_amount = $employee->provident_fund;
                            $providentFund->save();
                   }
               }
        // provident fund end
        // loan start
           $logs                      = new LoanApplicationLog();
           $loanDetails = LoanApplication::where('employee_id',$employee_id)->whereStatus(1)->whereNot('paid_status',1)->get();
           foreach ($loanDetails as $val){
                $dueAmount = ($val->due_amount - $salary_generate_history->loan_amount);
                if($dueAmount <=0){
                    $val->due_amount           = $dueAmount;
                    $val->paid_amount          =  $val->paid_amount + $salary_generate_history->loan_amount;
                    $val->paid_status          = 1;
                    $val->save();

                    $logs->loan_application_id = $val->id;
                    $logs->loan_pay_date       = Carbon::now();
                    $logs->pay_amount          = $salary_generate_history->loan_amount;
                    $logs->due_amount          = $dueAmount;
                    $logs->save();
                }else{
                    $val->due_amount           = $dueAmount;
                    $val->paid_amount          = $val->paid_amount + $salary_generate_history->loan_amount;
                    $val->paid_status          = 2;
                    $val->save();

                    $logs->loan_application_id = $val->id;
                    $logs->loan_pay_date       = Carbon::now();
                    $logs->pay_amount          = $salary_generate_history->loan_amount;
                    $logs->due_amount          = $dueAmount;
                    $logs->save();
                }

        }
        // loan end

        //PF loan start
        $pf_logs                      = new ProvidentLoanLog();
        $pf_loanDetails = ProvidentLoan::where('employee_id',$employee_id)->whereStatus(1)->whereNot('paid_status',1)->get();
        foreach ($pf_loanDetails as $val){
            $dueAmount = ($val->due_amount - $salary_generate_history->pf_loan_amount);
            if($dueAmount <=0){
                $val->due_amount           = $dueAmount;
                $val->paid_amount          =  $val->paid_amount + $salary_generate_history->pf_loan_amount;
                $val->paid_status          = 1;
                $val->save();

                $pf_logs->provident_loan_id = $val->id;
                $pf_logs->pf_loan_pay_date       = Carbon::now();
                $pf_logs->pay_amount          = $salary_generate_history->pf_loan_amount;
                $pf_logs->due_amount          = $dueAmount;
                $pf_logs->save();
            }else{
                $val->due_amount           = $dueAmount;
                $val->paid_amount          = $val->paid_amount + $salary_generate_history->pf_loan_amount;
                $val->paid_status          = 2;
                $val->save();

                $pf_logs->provident_loan_id = $val->id;
                $pf_logs->pf_loan_pay_date       = Carbon::now();
                $pf_logs->pay_amount          = $salary_generate_history->pf_loan_amount;
                $pf_logs->due_amount          = $dueAmount;
                $pf_logs->save();
            }

        }
        // PF loan end

        $advanceAmountDetails =  SalaryAdvance::where('employee_id',$employee_id)->where('paid_status',0)->where('status',1)->where('sd_date','>=',$start_date)->where('sd_date','<=',$end_date)->get();
        foreach ($advanceAmountDetails as $val){
            $val->paid_status = 1;
            $val->save();
        }
        $salary_generate_history->status = 1;
        $salary_generate_history->save();
        return redirect()->route('admin.payroll.salary-generate-list')->with('message','Successfully Salary Generated !');
    }


    public function salaryGeneratePDF($id)
    {
        $salary_generate_history =  SalaryGenerate::find($id);
        $year = Carbon::parse($salary_generate_history->generate_date)->format('Y');
        $month = Carbon::parse($salary_generate_history->generate_date)->format('m');
        $start_date = $year.'-'.$month.'-'.'01';
        $end_date = $year.'-'.$month.'-'.'31';

        $employee_id = $salary_generate_history->employee_id;
        $salaryAllowance = SalaryAllowance::where('allowance_name','like','%'.'basic'.'%')->first();
        $basicSalaryInfo = EmployeeSalary::where('employee_id',$employee_id)->where('salary_allowance_id',$salaryAllowance->id)->first();
        $basic =  $basicSalaryInfo->salary;

        $allowanceAmountDetails = EmployeeSalary::where('employee_id',$employee_id)->whereNot('salary_allowance_id',$salaryAllowance->id)->get();
        $allowanceAmount = $allowanceAmountDetails->sum('salary');

        $addtionalAllowanceAmountDetails =  AdditionalAllowanceDistribution::where('employee_id',$employee_id)->where('allowance_date','>=',$start_date)->where('allowance_date','<=',$end_date)->get();
        $addtionalAllowanceAmount = $addtionalAllowanceAmountDetails->sum('allowance');
        $grossSalary = $basicSalaryInfo->salary + $allowanceAmount+$addtionalAllowanceAmount;

        $loanAmount =  $salary_generate_history->loan_amount;

        $advanceAmountDetails =  SalaryAdvance::where('employee_id',$employee_id)->where('paid_status',1)->where('status',1)->where('sd_date','>=',$start_date)->where('sd_date','<=',$end_date)->get();
        //$advanceAmount = $advanceAmountDetails->sum('amount');
        $advanceAmount = $salary_generate_history->advance_amount;
        $addtionalDeductionAmountDetails =  AdditionalDeductionPenalty::where('employee_id',$employee_id)->where('deduction_date','>=',$start_date)->where('deduction_date','<=',$end_date)->get();
        $addtionalDeductionAmount = $addtionalDeductionAmountDetails->sum('deduction');

        $lateRules =  LateDeductionRules::where('status',1)->first();
        $lateAttendances=  Attendance::where('employee_id',$employee_id)->where('date','>=',$start_date)->where('date','<=',$end_date)->get();
        // $workingDays = count($lateAttendances);
        // WORKING DAYS COUNT START
        $numberOfDaysInMonth = Carbon::now()->daysInMonth;
        $weeksIhisMonth      = $this->weeksInMonth($numberOfDaysInMonth);
        $leaveDays           = WeeklyHoliday::sum('weeklyleave');
        $monthHoliday        = Holiday::whereMonth('from_holiday','=',Carbon::now()->month)->sum('number_of_days');
        $totalHoliday        = (intval($weeksIhisMonth)) * (intval($leaveDays));
        $workingDays         = $numberOfDaysInMonth - $totalHoliday - $monthHoliday;

       // WORKING DAYS COUNT END
        // $workingDays = 24;
        $totalLateAttendaance =  $lateAttendances->where('late','!=',null)->count();
        $lateDays = intval($totalLateAttendaance/($lateRules->late_days));
        $netWorkingDays = $workingDays - $lateDays;
        $salaryAllowancePerDays =  EmployeeSalary::where('employee_id',$employee_id)->where('salary_allowance_id',$lateRules->salary_allowance_id)->first();
        $perDaySalary = $salaryAllowancePerDays->salary /$workingDays;
        $totalLateDeductionAmount = intval($perDaySalary * $lateDays);

        $allDeductionAmount = $loanAmount + $advanceAmount+$addtionalDeductionAmount+$totalLateDeductionAmount;
        $netSalary = $grossSalary-$allDeductionAmount;
        $setting = Settings::first();
        $pdf = PDF::loadview('admin.pdf.salary-payslip', compact('setting','netSalary','allDeductionAmount','totalLateDeductionAmount','addtionalDeductionAmountDetails','advanceAmount','loanAmount','grossSalary','addtionalAllowanceAmountDetails','allowanceAmountDetails','basic','netWorkingDays','salary_generate_history'))->setOptions(['defaultFont' => 'sans-serif']);
        return $pdf->setPaper('a4')->stream('report.pdf');
    }
    // WEEK IN THIS MONTH
    public function weeksInMonth($numOfDaysInMonth)
    {
        $daysInWeek = 7;
        $daysInMonth = $numOfDaysInMonth;
        $result = $daysInMonth/$daysInWeek;
        $numberOfFullWeeks = floor($result);
        $numberOfRemaningDays = ($result - $numberOfFullWeeks)*7;
        return $numberOfFullWeeks;
    }
}
