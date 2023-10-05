<div class="panel panel-default">
    <div class="panel-heading">
        <h4 style="color: #605CA8;">Employee On Leave</h4>
        <button  style="float: right;margin-top: -40px;" type="button" class="btn btn-warning text-right" id="btnPrint" onclick="printPageArea('printableArea');">
            <i class="fa fa-print"></i>
        </button>
    </div>
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
                        <th class="text-center fs-20">Employee Leave Report</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
        <br>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>Employee ID</th>
                <th>Name</th>
                <th>Department</th>
                <th>Leave Type</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>

            @foreach($leave_applications as $key=>$leave)
                <tr>
                    <th scope="row">{{ $key+1 }}</th>
                    <td>{{$leave->employee->employee_manual_id}}</td>
                    <td>{{$leave->employee->first_name.' '.$leave->employee->last_name}}</td>
                    <td>{{$leave->department->department_name}}</td>
                    <td>{{$leave->leave_type->leave_name}}</td>
                    <td>{{$leave->start_date}}</td>
                    <td>{{$leave->end_date}}</td>
                    @if($leave->status == 0)
                        <td><strong style="color: #dd4b39"> Pending</strong> </td>
                    @elseif($leave->status == 1)
                        <td><strong style="color: darkgreen"> Approved</strong> </td>
                    @else
                        <td><strong style="color: red"> Rejected</strong> </td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <!-- responsive table div ends -->
</div>
