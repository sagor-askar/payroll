<div class="panel panel-default">
    <div class="panel-heading">
        <h4 style="color: #605CA8;">Monthly Present Details</h4>
    </div>
    <div class="table-responsive">
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
            </tr>
            </thead>
            <tbody>
            @foreach($monthly_leave as $key=>$monthly_attend)
                <tr>
                    <th scope="row">{{$key+1}}</th>
                    <td>{{$monthly_attend->employee->employee_manual_id}}</td>
                    <td>{{$monthly_attend->employee->first_name.' '.$monthly_attend->employee->last_name}}</td>
                    <td>{{$monthly_attend->employee->department->department_name}}</td>
                    <td>{{$monthly_attend->date}}</td>
                    <td>{{$monthly_attend->clock_in}}</td>
                    <td>{{$monthly_attend->clock_out}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
