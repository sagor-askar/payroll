@extends('layouts.admin')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                      Show Salary Information
                    </div>
                <div class="panel panel">
                    <div class="form-group">
                  <br>
                    <div class="form-group">
                        <a class="btn btn-default" href="{{ route('admin.payroll.salary-generate-list') }}">
                            {{ trans('global.back_to_list') }}
                        </a>
                    </div>
                            <div style="padding:20px;">
                                <div class="row mb-10">
                                    <table width="99%">
                                        <thead>
                                        <tr style="height: 40px;background-color: #E7E0EE;">
                                            <th class="text-center fs-20">Salary Details</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                                <br>
                                <div class="row">
                                    <table width="99%" class="payrollDatatableReportPaySlip table table-striped table-bordered table-hover">
                                        <tbody>
                                        <tr style="text-align: left;">
                                            <th>Employee Id</th>
                                            <td>{{ $salary_generate_history->employee->employee_manual_id }}</td>
                                            <th>Month</th>
                                            <td>{{\Carbon\Carbon::parse($salary_generate_history->generate_date)->format('F') }}</td>
                                        </tr>
                                        <tr style="text-align: left;">
                                            <th>Employee Name</th>
                                            <td>{{ $salary_generate_history->employee->first_name.' '.$salary_generate_history->employee->last_name }}</td>
                                            <th>Year</th>
                                            <td>{{\Carbon\Carbon::parse($salary_generate_history->generate_date)->format('Y') }}</td>
                                        </tr>
                                        <tr style="text-align: left;">
                                            <th>Department</th>
                                            <td>{{ $salary_generate_history->employee->department->department_name }}</td>
                                            <th>Generated Date</th>
                                            <td>{{\Carbon\Carbon::parse($salary_generate_history->generate_date)->format('d-F-Y') }}</td>
                                        </tr>
                                        <tr style="text-align: left;">
                                            <th>Position</th>
                                            <td>{{ $salary_generate_history->employee->designation->designation_name }}</td>
                                            <th>Contact</th>
                                            <td>{{ $salary_generate_history->employee->contact_no }}</td>
                                        </tr>
                                        <tr style="text-align: left;">
                                            <th>Address</th>
                                            <td>{{ $salary_generate_history->employee->address }}</td>
                                            <th>Working Days</th>
                                            <td>{{ $present_workingDays }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row">
                                    <br>
                                    <table width="99%" class="table table-bordered table-striped">
                                        <thead>
                                        <tr style="text-align: left;background-color: #E7E0EE;">
                                            <th>Description</th>
                                            <th> Amount</th>
                                            <th>Total Amount</th>
                                            <th>Net Amount</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr style="text-align: left;">
                                            <th>Basic Salary</th>
                                            <td>{{$basic}}</td>
                                        </tr>
                                        <tr style="text-align: left;">
                                            <th>Allowance Details</th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                        @foreach($allowanceAmountDetails as $val)
                                          <tr style="text-align: left;">
                                            <td>{{$val->salary_allowance->allowance_name}}</td>
                                            <td>{{$val->salary}}</td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        @endforeach


                                        @foreach($addtionalAllowanceAmountDetails as $val)
                                            <tr style="text-align: left;">
                                                <td>{{$val->additional_allowance_setup->allowance_name}}</td>
                                                <td>{{$val->allowance}}</td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        @endforeach


                                            <tr style="text-align: left;">
                                                <td>Marketing Allowance</td>
                                                <td>{{$salary_generate_history->employee->marketing_allowance}}</td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr style="text-align: left;">
                                                <td>Mobile Allowance</td>
                                                <td>{{$salary_generate_history->employee->mobile_bill}}</td>
                                                <td></td>
                                                <td></td>
                                            </tr>


                                            <tr style="text-align: left;">
                                                <td>OverTime Salary</td>
                                                <td>{{$ot_salary}}</td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        @if($bonus > 0)
                                        <tr style="text-align: left;">
                                            <td> Bonus</td>
                                            <td>{{$bonus}}</td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        @endif

                                        <tr style="text-align: left;">
                                            <th>Gross Salary</th>
                                            <th></th>
                                            <th>{{$grossSalary}}</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                        <tr style="text-align: left;">
                                            <th>Deduction Details</th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>

                                        <tr style="text-align: left;">
                                            <td>Loan Amount</td>
                                            <td>{{$loanAmount}}</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr style="text-align: left;">
                                            <td>Provident Fund Loan Amount</td>
                                            <td>{{$pf_loanAmount}}</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                            <tr style="text-align: left;">
                                                <td>Advance Amount</td>
                                                <td>{{$advanceAmount}}</td>
                                                <td></td>
                                                <td></td>
                                            </tr>

                                        @foreach($addtionalDeductionAmountDetails as $val)
                                            <tr style="text-align: left;">
                                                <td>{{$val->additional_deduction_setup->deduction_name}}</td>
                                                <td>{{$val->deduction}}</td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        @endforeach




                                        <tr style="text-align: left;">
                                            <td>Late Attendance Deduction</td>
                                            <td>{{$totalLateDeductionAmount}}</td>
                                            <td></td>
                                            <td></td>

                                        </tr>


                                        <tr style="text-align: left;">
                                            <td>Tax  </td>
                                            <td>{{$salary_generate_history->employee->tax}}</td>
                                            <td></td>
                                            <td></td>

                                        </tr>

                                        <tr style="text-align: left;">
                                            <td>Provident Fund</td>
                                            <td>{{$salary_generate_history->employee->provident_fund}}</td>
                                            <td></td>
                                            <td></td>

                                        </tr>



                                        <tr style="text-align: left;">
                                            <th>Total Deductions</th>
                                            <th></th>
                                            <th>{{$allDeductionAmount}}</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                        <tr style="text-align: left;">
                                            <th colspan="3" align="left">NET SALARY</th>
                                            <th align="left">{{$netSalary}}</th>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                      @if($salary_generate_history->status == 0)
                        <div class="form-group" style="margin-left: 460px;" >
                            <a class="btn-lg btn-primary" href="{{ route('payroll-salary-generate.confirm', $salary_generate_history->id) }}">
                           Confirm?
                            </a>
                        </div>
                      @else

                    <div class="form-group" style="margin-left: 460px;" >
                        <button  class="button">
                            Salary Generated
                        </button>
                    </div>
                  @endif
                </div>
                </div>
                </div>
            </div>

        </div>
    </div>
@endsection
