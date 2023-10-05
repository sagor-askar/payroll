<div class="panel panel-default">
    <div class="panel-heading" style="padding: 2px;">
        <h4 style="color: #605CA8;">Monthly Present Details</h4>
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
                        <th class="text-center fs-20"> Monthly Presents Report</th>
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
                <th>Date</th>
                <th>In Time</th>
                <th>Out Time</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            @foreach($monthly_attendance as $key=>$monthly_attend)
                <tr>
                    <th scope="row">{{$key+1}}</th>
                    <td>{{$monthly_attend->employee->employee_manual_id}}</td>
                    <td>{{$monthly_attend->employee->first_name.' '.$monthly_attend->employee->last_name}}</td>
                    <td>{{$monthly_attend->employee->department->department_name}}</td>
                    <td>{{$monthly_attend->date}}</td>
                    <td>{{$monthly_attend->clock_in}}</td>
                    <td>{{$monthly_attend->clock_out}}</td>
                    @if ($monthly_attend->late == null)
                    <td style="color: green">Present</td>
                    @else
                    <td style="color: red">Late</td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
