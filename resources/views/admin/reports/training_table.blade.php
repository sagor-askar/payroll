<div class="panel panel-default">

    <div class="panel-heading">
        <h4 style="color: #605CA8;"><b>Training History</b></h4>
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
                                <th class="text-center fs-20"> Training Report</th>
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
                        <th>Employee name</th>
                        <th>Trainer</th>
                        <th>Training Type</th>
                        <th> Training Skill </th>
                        <th> Cost</th>
                        <th>Start Date </th>
                        <th>End Date</th>
                        <th> Remarks </th>
                        <th> Performance </th>
                        <th>{{ trans('cruds.leaveApplication.fields.status') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($trainingReportsHistory as $trainingReport)
                        <tr class="loanDetails" data-loan='["{{$trainingReport->id}}"]'>
                            <td>{{ $trainingReport->id }}</td>
                            <td>{{ $trainingReport->employee->first_name.' '.$trainingReport->employee->last_name }}</td>
                            <td>{{ $trainingReport->trainer->name }}</td>
                            <td> {{ $trainingReport->training_type->name ?? '' }}</td>
                            <td>{{ $trainingReport->trainingSkill->name ?? '' }}</td>
                            <td> {{ $trainingReport->cost ?? '' }}</td>
                            <td> {{ \Carbon\Carbon::parse($trainingReport->start_date)->format('d-m-Y')  ?? '' }}</td>
                            <td>  {{ \Carbon\Carbon::parse($trainingReport->end_date)->format('d-m-Y')  ?? '' }}</td>
                            <td>  {{ $trainingReport->remarks ?? '' }}</td>

                            @if($trainingReport->performance == null)
                                <td><strong style="color: #dd4b39"> Not Yet</strong> </td>
                            @elseif($trainingReport->performance == 1)
                                <td><strong style="color: darkgreen"> Excellent</strong> </td>
                            @elseif($trainingReport->performance == 2)
                                <td><strong style="color: green"> Satisfactory</strong> </td>
                            @elseif($trainingReport->performance == 3)
                                <td><strong style="color: #DA9922FF"> Average</strong> </td>
                            @elseif($trainingReport->performance == 4)
                                <td><strong style="color: #DA5922FF"> Poor</strong> </td>
                            @else
                                <td><strong style="color: red"> Not Concluded</strong> </td>
                            @endif

                            @if($trainingReport->status == 0)
                                <td><strong style="color: #dd4b39"> Pending</strong> </td>
                            @elseif($trainingReport->status == 1)
                                <td ><strong style="color: #FF6B02FF"> Started</strong> </td>
                            @elseif($trainingReport->status == 2)
                                <td><strong style="color: darkgreen"> Completed</strong> </td>
                            @else
                                <td><strong style="color: red"> Terminated</strong> </td>
                            @endif
                        </tr>
                    @endforeach
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
