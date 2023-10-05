 <div class="text-right">
        <button type="button" class="btn btn-warning" id="" onclick="" autocomplete="">
            <i class="fa fa-print" title="Print From Here"></i>
        </button>
        <button type="button" class="btn btn-warning" id="" onclick="" autocomplete="">
            <i class="fa fa-file-pdf-o" title="Make a PDF From Here"></i>
        </button>
    </div>
    <br>

    <!-- lower table design -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 style="color: #605CA8;"><b>Leave Log History</b></h4>
        </div>

        <div class="panel-body">
            <!-- table UI -->
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th colspan="1">Basic Info</th>
                        <th colspan="3">Budget</th>
                        <th colspan="3">Approved Leave</th>
                        <th colspan="3">Remaining Leave</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th>Employee Name</th>

                        <!-- budget -->
                        @foreach($leaveTypes as $l_type)
                            <th>{{$l_type->leave_name}}</th>
                        @endforeach
                        <!-- approved leave -->
                        @foreach($leaveTypes as $l_type)
                            <th style="color: red">{{$l_type->leave_name}}</th>
                        @endforeach

                        <!-- remaining leave -->
                        @foreach($leaveTypes as $l_type)
                            <th style="color: green">{{$l_type->leave_name}}</th>
                        @endforeach
                    </tr>
                    @foreach($leave_log_history as $leave_log)
                        <tr>
                            <td>{{$leave_log->employee->first_name.' '.$leave_log->employee->last_name}}</td>

                            <!-- budget -->
                            @foreach($leaveTypes as $l_type)
                                <td>{{$l_type->no_of_days}}</td>
                            @endforeach
                            <!-- approved leave -->
                            @foreach($leaveTypes as $key=> $l_type)
                                @php
                                    $emp_id = $leave_log->employee_id;
                                     $approded_leave = \App\Models\LeaveApplication::where('employee_id',$emp_id)
                                     ->select(DB::raw("SUM(no_of_days) as total_days"))
                                     ->groupBy('leave_type_id')
                                     ->where('leave_type_id',$l_type->id)
                                     ->where('status',1)
                                     ->get()->sum('total_days');
                                @endphp
                                <td style="color: red">{{$approded_leave}}</td>
                            @endforeach

                            @foreach($leaveTypes as $key=> $l_type)
                                @php
                                    $emp_id = $leave_log->employee_id;
                                     $approded_leave = \App\Models\LeaveApplication::where('employee_id',$emp_id)
                                     ->select(DB::raw("SUM(no_of_days) as total_days"))
                                     ->groupBy('leave_type_id')
                                     ->where('leave_type_id',$l_type->id)
                                     ->where('status',1)
                                     ->get()->sum('total_days');
                                     $remaining_leave = $l_type->no_of_days - $approded_leave;
                                @endphp
                                <td style="color: green">{{$remaining_leave}}</td>
                            @endforeach
                        </tr>
                    @endforeach

                    </tbody>
                </table>

            </div>



        </div>
    </div>
