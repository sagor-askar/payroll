<div class="panel panel-default">
    <div class="panel-heading" style="padding: 2px;">
        <h4 style="color: #605CA8;">Daily Absents Details</h4>
        <button  style="float: right;margin-top: -40px;" type="button" class="btn btn-warning text-right" id="btnPrint" onclick="printAbsentPageArea('prinAbsenttableArea');">
            <i class="fa fa-print"></i>
        </button>
    </div>
    <div class="table-responsive" id="prinAbsenttableArea">
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
                        <th class="text-center fs-20"> Daily Presents Report</th>
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
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            @foreach($daily_absence_list as $key=> $daily_abs)
            
                <tr>
                    <th scope="row">{{$key+1}}</th>
                    <td>{{$daily_abs->employee_manual_id}}</td>
                    <td>{{$daily_abs->first_name. ' '.$daily_abs->last_name}}</td>
                    <td>{{$daily_abs->department->department_name}}</td>
                    <td>{{$absent_date}}</td>
                    <td style="color: red">Absent</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <!-- table responsive div ends -->
</div>
