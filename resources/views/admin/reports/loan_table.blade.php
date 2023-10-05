<div class="panel panel-default">

    <div class="panel-heading">
        <h4 style="color: #605CA8;"><b>Loan History</b></h4>
        <button  style="float: right;margin-top: -40px;" type="button" class="btn btn-warning text-right" id="btnPrint" onclick="printPageArea('printableArea');">
            <i class="fa fa-print"></i>
        </button>
    </div>
    <div class="panel-body">
        <form method="POST" id="basic-form"  action="" enctype="multipart/form-data">
            @csrf
            <div class="table-responsive" id="printableArea">
                <br>
                <div class="heading">
                    <table width="99%" style="margin-top: -50px;" >
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
                                <th class="text-center fs-20"> Loan Report</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <br>
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th colspan="1">#</th>
                        <th>Employee ID</th>
                        <th>Name</th>
                        <th>Loan Ammount</th>
                        <th>Per Installment</th>
                        <th>Total Paid</th>
                        <th>Total Due</th>
                        <th>Approved Date</th>
                        <th>Paid Status</th>
                        <th>Approved By</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $total_amount = 0;
                        $total_loan_amount = 0;
                        $total_due_amount = 0;
                    @endphp


                    @foreach($loanReportsHistory as $loanReport)

                        @php
                            $total_amount += $loanReport->amount;
                            $total_loan_amount += $loanReport->paid_amount;
                            $total_due_amount += $loanReport->due_amount;
                        @endphp

                        <tr class="loanDetails" data-loan='["{{$loanReport->id}}"]'>
                            <td>
                                {{ $loanReport->id ?? ''  }}
                                <input type="hidden" name="loan_id" id="loan_id" value="{{ $loanReport->id }} ">
                            </td>
                            <td>{{ $loanReport->employee->employee_manual_id }}</td>
                            <td>{{ $loanReport->employee->first_name.' '.$loanReport->employee->last_name }}</td>
                            <td>{{ $loanReport->amount }}</td>
                            <td>{{ $loanReport->installment_amount }}</td>
                            <td>{{ $loanReport->paid_amount }}</td>
                            <td>{{ $loanReport->due_amount }}</td>
                            <td>{{ $loanReport->approved_date }}</td>
                            @if($loanReport->paid_status == 0)
                                <td>
                                    Unpaid
                                </td>
                            @elseif($loanReport->paid_status == 1)
                                <td>
                                    Paid
                                </td>
                            @else
                                <td>
                                    Partial Paid
                                </td>
                            @endif

                            <td>{{ $loanReport->permitted_employee->name }}</td>
                            <td>


                                <button type="button" class="button loanView" data-toggle="modal"  data-target="#exampleModal">
                                    History

                                </button>


                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <th scope="row"></th>
                        <td colspan="1"><b>Total: </b></td>
                        <td></td>
                        <td  colspan="">{{$total_amount}} <b>TK</b></td>
                        <td></td>
                        <td colspan="">{{$total_loan_amount}} <b>TK</b></td>
                        <td colspan="">{{$total_due_amount}} <b>TK</b></td>
                        <td></td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="exampleModalLabel">Installment History of Employee</h4>
                            </div>
                            <div class="modal-body">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">Date</th>
                                        <th scope="col">Paid Amount</th>
                                        <th scope="col">Due Amount</th>
                                    </tr>
                                    </thead>
                                    <tbody id="loanhistoryTable">

                                    </tbody>
                                </table>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="button" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </form>
    </div>
</div>
