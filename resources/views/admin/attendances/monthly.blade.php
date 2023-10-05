@extends('layouts.admin')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 style="color: #605CA8;"><b>Create Monthly Attendance</b></h4>
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route("admin.attendances.setup") }}" enctype="multipart/form-data">
                        @csrf
                        <!-- monthly attendance form || Sagor -->

                        <div class="row">
                            <div class="col-md-12">
                                @if($role_title == "Employee")

                                <div class="form-group col-md-4 {{ $errors->has('employee') ? 'has-error' : '' }}">
                                    <label class="required" for="employee_id">{{ trans('cruds.attendance.fields.employee') }}</label>
                                    <select class="form-control select2" name="employee_id" id="employee_id" required>
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

                                @endif


                                <div class="form-group col-md-4{{ $errors->has('start_date') ? 'has-error' : '' }}">
                                    <label class="required" for="date">From:</label>
                                    <input class="form-control date" placeholder="Pick a date" type="text" name="start_date" id="start_date" value="{{ old('start_date') }}" required>
                                    @if($errors->has('start_date'))
                                    <span class="help-block" role="alert">{{ $errors->first('start_date') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.attendance.fields.date_helper') }}</span>
                                </div>

                                    <div class="form-group col-md-4 {{ $errors->has('end_date') ? 'has-error' : '' }}">
                                        <label class="required" for="date">To:</label>
                                        <input class="form-control date" placeholder="Pick a date" type="text" name="end_date" id="end_date" value="{{ old('end_date') }}" required>
                                        @if($errors->has('end_date'))
                                            <span class="help-block" role="alert">{{ $errors->first('end_date') }}</span>
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

            @if(count($dates) > 0 )
            <div class="panel-default">
                <form method="POST" action="{{ route("admin.attendances.store_all") }}" enctype="multipart/form-data">
                    @csrf
                    <div class="panel panel-bd">
                        <div class="table-responsive">
                            <div class="panel-heading">
                                <h4 style="color: #605CA8;">Monthly Attendance Details</h4>
                            </div>
                            <table class="table table-striped">

                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Designtation</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Clock In</th>
                                        <th scope="col">Clock Out</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach( $dates as $key=>$date)
                                    @php
                                    $inputdate = \Carbon\Carbon::parse( $date)->format('Y-m-d');
                                    @endphp
                                    <tr style="background-color: #efeff6;">
                                        <th scope="row">{{$key +1}}</th>
                                        <td>{{$employee_info->first_name . ' '.$employee_info->last_name}}</td>
                                        <td>{{$employee_info->designation->designation_name}}</td>
                                        <td>
                                            <input type="text" class="form-control" name="date[]" id="inlineFormInput" readonly required value="{{$inputdate}}" style="width: auto;">
                                        </td>
                                        <td>
                                            <input class="form-control" type="time" name="clock_in[]" id="clock_in" value="{{ old('clock_in') }}" required>
                                        </td>
                                        <td>
                                            <input class="form-control" type="time" name="clock_out[]" id="clock_out" value="{{ old('clock_out') }}" required>
                                        </td>
                                        <input type="hidden" name="employee_id" value="{{ $employee_info->id }}">

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>

                    <div>
                        <button class="button" type="submit">
                            SAVE
                        </button>
                    </div>

                </form>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
