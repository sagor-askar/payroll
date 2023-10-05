@extends('layouts.admin')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Monthly Salary Information of <b> {{ $date }} </b>
                </div>
                <div class="panel panel">
                    <div class="form-group">
                        

                        <div style="padding:20px; margin-top: -14px;">
                            <div class="row">
                                <br>
                                <table width="99%" class="table table-bordered table-striped">
                                    <thead>
                                        <tr style="text-align: center; background-color: #605CA8; color: white;">
                                            <th colspan="1">Description</th>
                                            <th colspan="2"> Amounts</th>
                                        </tr>
                                        <tr style="text-align: left;background-color: #E7E0EE;">
                                            <th></th>
                                            <th>Debit</th>
                                            <th>Credit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr style="text-align: left;">
                                            <th>Total Gross Salary</th>
                                            <td>{{ $totalSalary }} ৳</td>
                                            <td></td>
                                        </tr>
                                        <tr style="text-align: left;">
                                            <td>Total Additional Allowance</td>
                                            <td>{{ $totalAllowance }} ৳</td>
                                            <th></th>
                                        </tr>

                                        <tr style="text-align: left;">
                                            <td>Total Additional Deduction</td>
                                            <td></td>
                                            <td>{{ $totalDeduction }} ৳</td>
                                        </tr>

                                        <tr style="text-align: left;">
                                            <td>Total Provident Fund</td>
                                            <td></td>
                                            <td>{{ $totalProvidentFund }} ৳</td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- back button -->
                            <div class="form-group">
                                <a class="btn btn-default" href="{{ route('admin.payroll.payslipDetails') }}">
                                    {{ trans('global.back_to_list') }}
                                </a>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection