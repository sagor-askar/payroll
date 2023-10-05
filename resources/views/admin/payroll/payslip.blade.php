@extends('layouts.admin')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="panel panel-default">

            </div>
            <div class="panel panel-default thumbnail">
                <div class="panel-body">
                    <div class="text-right" id="print">
                        <button type="button" class="btn btn-warning" id="btnPrint" onclick="printPageArea('printableArea');"><i
                                class="fa fa-print"></i>
                        </button>
                    </div>
                    <br>
                    <div id="printableArea">
                        <div style="padding:10px;">
                            <table width="99%" style="margin-top: -50px;">
                                <tbody>
                                <tr>
                                    <td width="30%" align="left"  >
                                        <img  src="{{url('images/settings/',$setting->company_logo)}}"  alt="logo" style="margin-top: 25px ;max-width:80px;height: 80px; ">
                                    </td>
                                    <td width="40%" align="center" >
                                        <h3 style="padding-top: 20px;">{{ $setting->company_title }}</h3>
                                        <h6>{{ $setting->company_email }}</h6>
                                        <h6>{{ $setting->company_phone }}</h6>
                                        <h6>{{ $setting->company_address }}</h6>
                                    </td>
                                    <td width="30%" align="right">

                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="row mb-5">
                                <table width="99%">
                                    <thead>
                                    <tr style="height: 40px;background-color: #E7E0EE;">
                                        <th class="text-center fs-20">PAYSLIP</th>
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
                                <table width="99%" class="payrollDatatableReportPaySlip table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr style="text-align: left;background-color: #E7E0EE;">
                                        <th>Description</th>
                                        <th> Total Allowance Addition</th>
                                        <th>Total Deduction</th>
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
                                            <td>Overtime Salary</td>
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
                                        <th>{{$grossSalary}}</th>
                                        <th></th>
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
                                        <td></td>
                                        <td>{{$loanAmount}}</td>
                                        <td></td>
                                        <td></td>
                                    </tr>

                                    <tr style="text-align: left;">
                                        <td>Provident Fund Loan Amount</td>
                                        <td></td>
                                        <td>{{$pf_loanAmount}}</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr style="text-align: left;">
                                        <td>Advance Amount</td>
                                        <td></td>
                                        <td>{{$advanceAmount}}</td>
                                        <td></td>
                                    </tr>

                                    @foreach($addtionalDeductionAmountDetails as $val)
                                        <tr style="text-align: left;">
                                            <td>{{$val->additional_deduction_setup->deduction_name}}</td>
                                            <td></td>
                                            <td>{{$val->deduction}}</td>
                                            <td></td>
                                        </tr>
                                    @endforeach

                                    <tr style="text-align: left;">
                                        <td>Late Attendance Deduction</td>
                                        <td></td>
                                        <td>{{$totalLateDeductionAmount}}</td>
                                        <td></td>
                                    </tr>


                                    <tr style="text-align: left;">
                                        <td>Tax  </td>
                                        <td></td>
                                        <td>{{$salary_generate_history->employee->tax}}</td>
                                        <td></td>
                                    </tr>

                                    <tr style="text-align: left;">
                                        <td>Provident Fund</td>
                                        <td></td>
                                        <td>{{$salary_generate_history->employee->provident_fund}}</td>
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

                                <div class="row" style="margin-top: 15px; ">
                                    <div class="column" style="float: left;padding: 20px;width: 33.33%">
                                        <p>.........................</p>
                                        <p style="margin-top: -10px;"><strong> Employee Signature</strong></p>
                                    </div>
                                    <div class="column" style="float: left;padding: 20px;width: 33.33%">

                                    </div>

                                    <div class="column"  style="float: left;padding: 20px;width: 33.33%">
                                        <p>.........................</p>
                                        <p style="margin-top: -10px;"><strong>Approved By</strong></p>
                                        <p style="margin-top: -10px;">{{$salary_generate_history->user->name}} <br> {{$salary_generate_history->user->company->comp_name}}</p>
                                    </div>
                                </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
@section('scripts')
    @parent
    <script type="text/javascript">
        function printPageArea(printableArea) {
            var printContents = document.getElementById("printableArea").innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>


@endsection
