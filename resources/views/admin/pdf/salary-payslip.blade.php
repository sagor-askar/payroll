<div class="content">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-default">

                </div>
                <div class="panel panel-default thumbnail">
                    <div class="panel-body">
                        <div class="text-right" id="print">
                            <button type="button" class="btn btn-warning" id="btnPrint" onclick="printPageArea('printArea');"><i
                                    class="fa fa-print"></i>
                            </button>
                            <a href="{{ route('admin.payroll.salary-generate.pdf',$salary_generate_history->id) }}" target="_blank"
                               title="download pdf">
                                <button class="btn btn-success btn-md" name="btnPdf" id="btnPdf"><i class="fa-file-pdf-o"></i> PDF</button>
                            </a>
                        </div>
                        <br>
                        <div id="printArea">
                            <div style="padding:20px;">
                                <br>
                                <div>

                                </div>
                                <div class="row mb-10">
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
                                            <td>{{ $netWorkingDays }}</td>
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

                                        <tfoot>
                                        <tr>
                                            <td colspan="5" class="noborder">
                                                <table border="0" width="100%" style="padding-top: 50px;border: none !important;">
                                                    <tbody>
                                                    <tr border="0" style="height:50px;padding-top: 50px;border-left: none !important;">
                                                        <td align="left" class="noborder" width="30%">
                                                            <div class="border-top">Prepared By: <b>Super Admin<b></b></b></div><b><b>
                                                                </b></b>
                                                        </td>
                                                        <td align="left" class="noborder" width="30%">
                                                            <div class="border-top">Checked By</div>
                                                        </td>
                                                        <td align="left" class="noborder" width="20%">
                                                            <div class="border-top">Authorised By</div>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
