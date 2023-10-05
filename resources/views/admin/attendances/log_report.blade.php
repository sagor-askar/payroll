@extends('layouts.admin')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="panel panel-bd">
                <div class="panel-heading">
                    <div class="panel-title">
                        <h4 style="color: #605CA8;"><b>Attendance Log Report</b></h4>
                    </div>
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route("admin.attendances.log_search") }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-12">
                            @if( $role_title  == 'Employee')

                                <div class="form-group col-md-4 {{ $errors->has('employee') ? 'has-error' : '' }}">
                                    <label for="employee_id">{{ trans('cruds.attendance.fields.employee') }}</label>
                                    <select class="form-control select2" name="employee_id" id="employee_id">
                                        @foreach($employees as $id => $entry)
                                            <option selected value="{{ $id }}" {{ old('employee_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('employee'))
                                        <span class="help-block" role="alert">{{ $errors->first('employee') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.attendance.fields.employee_helper') }}</span>
                                </div>

                                @else
                                <div class="form-group col-md-4 {{ $errors->has('employee') ? 'has-error' : '' }}">
                                    <label for="employee_id">{{ trans('cruds.attendance.fields.employee') }}</label>
                                    <select class="form-control select2" name="employee_id" id="employee_id">
                                        @foreach($employees as $id => $entry)
                                            <option  value="{{ $id }}" {{ old('employee_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('employee'))
                                        <span class="help-block" role="alert">{{ $errors->first('employee') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.attendance.fields.employee_helper') }}</span>
                                </div>
                                @endif

                                <div class="form-group col-md-4{{ $errors->has('date') ? 'has-error' : '' }}">
                                    <label class="required" for="date">From:</label>
                                    <input class="form-control date" type="text" name="start_date" id="date" value="{{ $start_date  }}" required>
                                    @if($errors->has('date'))
                                        <span class="help-block" role="alert">{{ $errors->first('date') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.attendance.fields.date_helper') }}</span>
                                </div>
                                <div class="form-group col-md-4 {{ $errors->has('date') ? 'has-error' : '' }}">
                                    <label class="required" for="date">To:</label>
                                    <input class="form-control date" type="text" name="end_date" id="end_date" value="{{ $end_date  }}" required>
                                    @if($errors->has('date'))
                                        <span class="help-block" role="alert">{{ $errors->first('date') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.attendance.fields.date_helper') }}</span>
                                </div>
                            </div>

                        </div>

                        <div class="form-group col-md-4">
                           <button class="button" type="submit">
                               Search
                           </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- attendance table log design -->

            @if(count($attendances) > 0 )
                @php
                    $show_start_date = \Carbon\Carbon::parse($start_date)->format('d-m-Y');
                    $show_end_date = \Carbon\Carbon::parse($end_date)->format('d-m-Y');
                @endphp

            <div id="history_table" class="panel panel-bd">
            <table class="table caption-top">
                    <div class="panel-heading">
                        <h4 style="Text-align: left;">Attendance History of  <strong>{{ $show_start_date }}  To  {{ $show_end_date }} </strong>
                        </h4>
                    </div>

                    <thead>
                        <tr style="background-color: #605CA8; color: white;">
                            <th scope="col">#</th>
                            <th scope="col">Employee Name</th>
                            <th scope="col"> Date</th>
                            <th scope="col">Clock In</th>
                            <th scope="col">Clock Out</th>
                        </tr>
                    </thead>
                    <tbody>

                    @foreach($attendances as $key=> $attendence)
                        <tr>
                            <th scope="row">{{$key +1}}</th>
                            <td>{{$attendence->employee->first_name.' '.$attendence->employee->last_name }} </td>
                            <td> {{ $attendence->date }}</td>
                            <td> {{ $attendence->clock_in }}</td>
                            <td>{{ $attendence->clock_out }}</td>
{{--                            <td>--}}
{{--                                <a class="btn btn-xs btn-primary" href="{{ route('attendances.user_attendance_details', ['employee_id' => $attendence->employee_id ,'start_date' => $start_date, 'end_date' => $end_date]) }}">--}}
{{--                                    {{ trans('global.view') }}--}}
{{--                                </a>--}}
{{--                            </td>--}}
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            </div>
           @endif
        </div>
    </div>
</div>
@endsection
