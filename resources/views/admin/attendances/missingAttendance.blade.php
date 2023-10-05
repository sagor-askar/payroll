@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 style="color: #605CA8;"><b>Create Missing Attendance</b></h4>
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route("admin.missing.attendances.setup") }}" enctype="multipart/form-data">
                        @csrf
                        <!-- missing attendance form -->
                        <div class="col-md-6 col-sm-3">
                            <div class="form-group {{ $errors->has('employee') ? 'has-error' : '' }}">
                                <label class="required" for="employee_id">{{ trans('cruds.attendance.fields.employee') }}</label>
                                <select class="form-control select2" name="employee_id" id="employee_id" required>
                                    @foreach($employees as $id => $entry)
                                        <option  value="{{ $id }}" {{ old('employee_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-3">
                            <div class="form-group {{ $errors->has('date') ? 'has-error' : '' }}">
                                <label class="required" for="date">Date</label>
                                <input placeholder="Pick your date" class="form-control date" type="text" name="date" id="date" value="{{ old('date') }}" required>
                                @if($errors->has('date'))
                                    <span class="help-block" role="alert">{{ $errors->first('date') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.attendance.fields.date_helper') }}</span>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-3">
                            <button class="button" type="submit">
                                Search
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            @if($attendence_info == null && $employee_info !=null)
                <div class="panel-default">
                    <form method="POST" action="{{ route("admin.miss_attendances.store") }}" enctype="multipart/form-data">
                        @csrf                        
                        <div class="panel panel-bd">
                            <div class="panel-heading">
                                    <h4 style="color: #605CA8;">Missing Details of Employees</h4>
                                </div>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Designtation</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Clock In</th>
                                            <th scope="col">Clock Out</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td> </td>
                                            <td>{{$employee_info->first_name . ' '.$employee_info->last_name}}</td>
                                            <td>{{$employee_info->designation->designation_name}}</td>
                                            <td>
                                                <input type="text" class="form-control mb-2" name="date" id="inlineFormInput" readonly required value="{{$date}}" style="width: auto;">
                                            </td>
                                            <td>
                                                <input class="form-control" type="time" name="clock_in" id="clock_in" value="{{ old('clock_in') }}" required>
                                            </td>
                                            <td>
                                                <input class="form-control" type="time" name="clock_out" id="clock_out" value="{{ old('clock_out') }}" required>
                                            </td>
                                            <input type="hidden" name="employee_id"  value="{{ $employee_info->id }}">
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>

                        <div>
                            <button class="button" type="submit" style=" margin-right: 10%;">
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
