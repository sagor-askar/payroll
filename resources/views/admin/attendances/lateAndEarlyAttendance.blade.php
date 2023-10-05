@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 style="color: #605CA8;"><b>Late And Early Attendance</b></h4>
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route("admin.late_early_attendances.search") }}" enctype="multipart/form-data">
                        @csrf
                        <!-- lateness and early closing form -->
                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group {{ $errors->has('employee') ? 'has-error' : '' }}">
                                    <label class="required" for="employee_id">{{ trans('cruds.attendance.fields.employee') }}</label>
                                    <select class="form-control select2" name="employee_id" id="employee_id" required>
                                        @foreach($employees as $id => $entry)
                                            <option value="{{ $id }}" {{ old('employee_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('employee'))
                                        <span class="help-block" role="alert">{{ $errors->first('employee') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.attendance.fields.employee_helper') }}</span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="required" for="date">Year</label>
                                    <select class="form-control" name="year" id="ddlYears">
                                    </select>
                                    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js">
                                    </script>
                                    <script type="text/javascript">
                                        $(function() {
                                            var ddlYears = $("#ddlYears");

                                            var currentYear = (new Date()).getFullYear();

                                            for (var i = currentYear; i >= 1990; i--) {
                                                var option = $("<option />");
                                                option.html(i);
                                                option.val(i);
                                                ddlYears.append(option);
                                            }
                                        });
                                    </script>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="required" for="date">Month</label>
                                    <select class="form-control" name="month" id="month">
                                        <option value="">Select Month</option>
                                        <option value="01">January</option>
                                        <option value="02">February</option>
                                        <option value="03">March</option>
                                        <option value="04">April</option>
                                        <option value="05">May</option>
                                        <option value="06">June</option>
                                        <option value="07">July</option>
                                        <option value="08">August</option>
                                        <option value="09">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                       
                        <div class="form-group">
                            <button class="button" type="submit">
                            Details
                            </button>
                        </div>
                        

                    </form>
                </div>
            </div>

            @if(count($attendances_history) > 0 )
            <br>
            <!-- lower form design -->
            <div class="text-right">
                <button type="button" class="btn btn-warning" id="" autocomplete="">
                    <i class="fa fa-print"></i>
                </button>
                <button type="button" class="btn btn-warning" id="" onclick="" autocomplete="">
                    <i class="fa fa-file-pdf-o"></i>
                </button>
            </div>
            <br>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <td align="center" class="text-center logo image">
                            <h3><b>Payroll</b></h3>
                        </td>
                    </tr>
                    <tr>
                        <th align="center" class="text-center fs-20 action-title">
                            Late and Early Attendances ( <strong>{{ $employee_info->first_name.' '.$employee_info->last_name }}</strong> )
                        </th>
                    </tr>
                </thead>
            </table>

            <div class="panel panel-bd">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Date</th>
                            <th scope="col">In Time</th>
                            <th scope="col">Attendance Setup(in time)</th>
                            <th scope="col">Late Time</th>
                            <th scope="col">Out Time</th>
                            <th scope="col">Attendance Setup(out time)</th>
                            <th scope="col">Early Closing</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($attendances_history as $key=> $attend)
                        <tr>
                            <th scope="row">{{ $key +1 }}</th>
                            <td>{{ $attend->date }}</td>
                            <td>{{ $attend->clock_in }}</td>
                            <td>{{$rules->start_time}}</td>
                            <td>{{ $attend->late }}</td>
                            <td>{{ $attend->clock_out }}</td>
                            <td>{{$rules->end_time}}</td>
                            <td>{{ $attend->early_leaving }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <br>
                <br>
                <!-- lower section for signatures -->
                <table border="0" width="100%">
                    <tbody>
                        <td align="left" class="" width="30%">
                            <div class="border-top">
                                Prepared By: <b> {{ old('name', auth()->user()->name) }} </b>
                            </div>
                        </td>

                        <td align="left" class="" width="30%">
                            <div class="border-top">
                                Checked By: <b>HR Dept</b>
                            </div>
                        </td>

                        <td align="left" class="" width: 20%>
                            <div class="border-top">
                                Authorized By: <b>Admin</b>
                            </div>
                        </td>
                    </tbody>
                </table>
            </div>
            @endif

        </div>
    </div>
</div>
@endsection


