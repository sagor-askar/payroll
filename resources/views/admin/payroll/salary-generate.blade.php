@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 style="color: #605CA8;"><b>Generate Employee Salary</b></h4>
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route("payroll-salary-generate.search") }}" enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-3">
                            <div class="form-group {{ $errors->has('department') ? 'has-error' : '' }}">
                                <label for="department_id">{{ trans('cruds.leaveApplication.fields.department') }}</label>
                                <select class="form-control select2" id="department_id">
                                    <option value="">Select One</option>
                                    @foreach($departments as $id => $entry)
                                        <option value="{{ $id }}" {{ old('department_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('department'))
                                    <span class="help-block" role="alert">{{ $errors->first('department') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.leaveApplication.fields.department_helper') }}</span>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group {{ $errors->has('employee') ? 'has-error' : '' }}">
                                <label for="employee_id">{{ trans('cruds.attendance.fields.employee') }}</label>
                                <select class="form-control select2" name="employee_id" id="employee_id">
                                    <option value="">Select One</option>
                                    @foreach($employees as $id => $entry)
                                        <option value="{{ $entry->id }}" {{ old('employee_id') == $entry->id ? 'selected' : '' }}>{{ $entry->first_name.' '.$entry->last_name }} ({{$entry->employee_manual_id}})</option>
                                    @endforeach
                                </select>
                                @if($errors->has('employee'))
                                    <span class="help-block" role="alert">{{ $errors->first('employee') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.attendance.fields.employee_helper') }}</span>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="required" for="date">Year</label>
                                <select class="form-control" name="year" id="ddlYears">
                                </select>
                                <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js">
                                </script>
                                <script type="text/javascript">
                                    $(function() {
                                        var ddlYears = $("#ddlYears");

                                        var currentYear = (new Date()).getFullYear();

                                        for (var i = currentYear; i >= 1990; i--) {
                                            var option = $("<option />");
                                            option.html(i);
                                            option.val(i);
                                            ddlYears.append(option);
                                        }
                                    });
                                </script>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="required" for="date">Month</label>
                                <select class="form-control" name="month" id="month">
                                    <option value="">Select Month</option>
                                    <option value="01">January</option>
                                    <option value="02">February</option>
                                    <option value="03">March</option>
                                    <option value="04">April</option>
                                    <option value="05">May</option>
                                    <option value="06">June</option>
                                    <option value="07">July</option>
                                    <option value="08">August</option>
                                    <option value="09">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <button class="button" type="submit">
                                    Search
                                </button>
                            </div>

                        </div>

                    </form>
                </div>
            </div>

           @if(count($validEmployees) > 0)
            <div class="panel panel-default">
                <div class="panel-heading" style="padding: 2px;">
                    <h4 style="color: #605CA8;">Salary Generate Details</h4>
                    <button  style="float: right;margin-top: -40px;" type="button" class="btn btn-warning text-right" id="btnPrint" onclick="printPageArea('printableArea');">
                        <i class="fa fa-print"></i>
                    </button>
                </div>
                <div class="panel-body">
                    <form method="POST" id="basic-form"  action="{{ route("payroll-salary-generate.store") }}" enctype="multipart/form-data">
                        @csrf
                    <div class="table-responsive" id="printableArea">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th colspan="1">#</th>
                                    <th style="text-align: center" colspan="5">Employee Information</th>
                                    <th style="text-align: center" colspan="6">Additional Amount</th>
                                    <th style="text-align: center" colspan="7">Dedeuction Amount</th>
                                    <th style="text-align: center" colspan="1">Salary</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>SL</th>
                                    <th>Employee ID</th>
                                    <th>Name</th>
                                    <th>Designation</th>
                                    <th>Basic Salary</th>
                                    <th>Total Allowance</th>
                                    <th>Additional Allowance</th>
                                    <th>Mobile Allowance</th>
                                    <th>Marketing Allowance</th>
                                    <th>OverTime Salary</th>
                                    <th>Bonus</th>
                                    <th>Gross Salary</th>
                                    <th>Loan</th>
                                    <th>PF Loan</th>
                                    <th>Advance</th>
                                    <th>Deduction Amount</th>
                                    <th>Late Deduction</th>
                                    <th>Provident Fund</th>
                                    <th>Tax</th>
                                    <th>Total</th>
                                    <th>Net salary</th>
                                </tr>
                                @foreach($validEmployees as $key=> $validEmp)
                             @php
                              $employee_id = $validEmp->id;

                              $salaryAllowance = \App\Models\SalaryAllowance::where('allowance_name','like','%'.'basic'.'%')->first();
                              $basicSalaryInfo =  \App\Models\EmployeeSalary::where('employee_id',$employee_id)->where('salary_allowance_id',$salaryAllowance->id)->first();
                              $allowanceAmount =  \App\Models\EmployeeSalary::where('employee_id',$employee_id)->whereNot('salary_allowance_id',$salaryAllowance->id)->get()->sum('salary');
                              $addtionalAllowanceAmount =  \App\Models\AdditionalAllowanceDistribution::where('employee_id',$employee_id)->where('allowance_date','>=',$start_date)->where('allowance_date','<=',$end_date)->get()->sum('allowance');
                              $ot_salary =  \App\Models\OverTime::where('employee_id',$employee_id)->where('ot_date','>=',$start_date)->where('ot_date','<=',$end_date)->where('status',1)->get()->sum('ot_salary');
                              $bonusData =  \App\Models\Bonus::where('employee_id',$employee_id)->where('bonus_date','>=',$start_date)->where('bonus_date','<=',$end_date)->first();
                             if ($bonusData != null){
                                  $bonus    = $bonusData->amount;
                             }else{
                                 $bonus = 0 ;
                             }

                              $employee_info = \App\Models\Employee::find($employee_id);
                              $mobile_bill = $employee_info->mobile_bill;
                              $marketing_allowance = $employee_info->marketing_allowance;
                              $tax = $employee_info->tax;
                              $provident_fund = $employee_info->provident_fund;

                              $grossSalary = $basicSalaryInfo->salary + $allowanceAmount+$addtionalAllowanceAmount + $ot_salary +$mobile_bill + $marketing_allowance + $bonus ;
                                // LOAN AMOUNT START
                                // dd($start_date);

                                $loanDetails =  \App\Models\LoanApplication::where('employee_id',$employee_id)->where('adjustment_date','<=',$end_date)->where('status',1)->whereNot('paid_status',1)->get();
                                if ($loanDetails->isEmpty()) {
                                    $loanAmount = 0;
                                }else{
                                    foreach ($loanDetails as  $value) {
                                        if($value->due_amount >= $value->installment_amount){
                                            $loanAmount = $value->installment_amount;
                                        }else{
                                            $loanAmount = $value->due_amount;
                                        }
                                    }

                                }

                                //Provident Fund Loan

                                $providentLoans =  \App\Models\ProvidentLoan::where('employee_id',$employee_id)->where('adjustment_date','<=',$end_date)->where('status',1)->whereNot('paid_status',1)->get();
                                if ($providentLoans->isEmpty()) {
                                    $pf_loanAmount = 0;
                                }else{
                                    foreach ($providentLoans as  $value) {
                                        if($value->due_amount >= $value->installment_amount){
                                            $pf_loanAmount = $value->installment_amount;
                                        }else{
                                            $pf_loanAmount = $value->due_amount;
                                        }
                                    }

                                }

                                // LOAN AMOUNT END loanAmount
                              $advanceAmount =  \App\Models\SalaryAdvance::where('employee_id',$employee_id)->where('paid_status',0)->where('status',1)->where('sd_date','>=',$start_date)->where('sd_date','<=',$end_date)->get()->sum('amount');
                              $addtionalDeductionAmount =  \App\Models\AdditionalDeductionPenalty::where('employee_id',$employee_id)->where('deduction_date','>=',$start_date)->where('deduction_date','<=',$end_date)->get()->sum('deduction');
                              $lateRules =  \App\Models\LateDeductionRules::where('status',1)->first();
                             if ($lateRules){
                               $lateAttendances=  \App\Models\Attendance::where('employee_id',$employee_id)->where('date','>=',$start_date)->where('date','<=',$end_date)->get();
                               $totalLateAttendaance =  $lateAttendances->where('late','!=',null)->count();
                               $lateDays = intval($totalLateAttendaance/($lateRules->late_days));
                               $salaryAllowancePerDays =  \App\Models\EmployeeSalary::where('employee_id',$employee_id)->where('salary_allowance_id',$lateRules->salary_allowance_id)->first();
                               $perDaySalary = $salaryAllowancePerDays->salary /$workingDays;
                               $totalLateDeductionAmount = intval($perDaySalary * $lateDays);
                             }else{
                                 $totalLateDeductionAmount = 0;
                             }



                               $allDeductionAmount = $pf_loanAmount + $tax + $provident_fund+$loanAmount + $advanceAmount+$addtionalDeductionAmount+$totalLateDeductionAmount;

                                $netSalary = $grossSalary-$allDeductionAmount;

                             @endphp
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$validEmp->employee_manual_id}}</td>
                                    <td>{{$validEmp->first_name.' '.$validEmp->last_name}}</td>
                                    <td>{{$validEmp->designation->designation_name}}</td>
                                    <td>{{$basicSalaryInfo->salary}}</td>
                                    <td>{{$allowanceAmount}}</td>
                                    <td>{{$addtionalAllowanceAmount}}</td>
                                    <td>{{$mobile_bill}}</td>
                                    <td>{{$marketing_allowance}}</td>
                                    <td>{{$ot_salary}}</td>
                                    <td>{{$bonus}}</td>
                                    <td>{{$grossSalary}}</td>
                                    <td>{{$loanAmount}}</td>
                                    <td>{{$pf_loanAmount}}</td>
                                    <td>{{$advanceAmount}}</td>
                                    <td>{{$addtionalDeductionAmount}}</td>
                                    <td>{{  $totalLateDeductionAmount}}</td>
                                    <td>{{  $provident_fund}}</td>
                                    <td>{{  $tax}}</td>
                                    <td>{{$allDeductionAmount}}</td>
                                    <td>{{$netSalary}}</td>
                                </tr>
                                    <div>
                                        <input type="hidden" name="employee_id[]" value="{{$employee_id}}">
                                        <input type="hidden" name="basic_salary[]" value="{{$basicSalaryInfo->salary}}">
                                        <input type="hidden" name="allowance_amount[]" value="{{$allowanceAmount}}">
                                        <input type="hidden" name="addtional_allowance_amount[]" value="{{$addtionalAllowanceAmount}}">
                                        <input type="hidden" name="ot_salary[]" value="{{$ot_salary}}">
                                        <input type="hidden" name="bonus[]" value="{{$bonus}}">
                                        <input type="hidden" name="gross_salary[]" value="{{$grossSalary}}">
                                        <input type="hidden" name="loan_amount[]" value="{{$loanAmount}}">
                                        <input type="hidden" name="pf_loan_amount[]" value="{{$pf_loanAmount}}">
                                        <input type="hidden" name="advance_amount[]" value="{{$advanceAmount}}">
                                        <input type="hidden" name="addtional_deduction_amount[]" value="{{$addtionalDeductionAmount}}">
                                        <input type="hidden" name="total_late_deduction_amount[]" value="{{$totalLateDeductionAmount}}">
                                        <input type="hidden" name="all_deduction_amount[]" value="{{$allDeductionAmount}}">
                                        <input type="hidden" name="net_salary[]" value="{{$netSalary}}">
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>


                        <div class="form-group" style="margin-left: 460px;" >
                            <button  class="button" type="submit">
                                Salary Generate
                            </button>
                        </div>
                    </form>
                </div>
            </div>
               @endif

        </div>
    </div>
</div>
@endsection

@section('scripts')

<script type="text/javascript">
    $(document).ready(function () {
        $(document).on('change', '#department_id', function () {
            var id = $(this).val();
            $.ajax({
                type: 'get',
                url: '{{ route("admin.get_reporting_employee.employee") }}',
                data: {'id': id},
                dataType: "json",
                success: function (data) {
                    if(data){
                        $('#employee_id').empty();
                        $('#employee_id').focus;
                        $('#employee_id').append('<option value="0" required="" >Select One </option>');
                        $.each(data, function(key, value){
                            $('select[name="employee_id"]').append('<option value="'+ value.id +'">' + value.first_name+' '+ value.last_name +'('+value.employee_manual_id+')'+'</option>');
                        });
                    }else{
                        $('#employee_id').empty();
                    }
                },
                error: function () {

                }
            });
        });
    });

    function printPageArea(printableArea) {

            var printContents = document.getElementById("printableArea").innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();
            window.close;

            document.body.innerHTML = originalContents;
        }
</script>
@endsection
