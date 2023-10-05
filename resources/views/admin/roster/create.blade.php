
@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Upload Roster &nbsp;&nbsp;
                    <a class="buttonNew" href="{{ route('admin.rosters.download') }}" style="color: white;" style="float: right">
                        Download Sample
                     </a>
                </div>


                <div class="panel-body">
                    <form method="POST" action="{{ route("admin.rosters.search") }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 col-sm-3">
                                <div class="form-group {{ $errors->has('department') ? 'has-error' : '' }}">
                                    <label  for="department_id">Sub Company</label>
                                        <select class="form-control select2" name="department_id" id="department_id" >
                                            <option value="">Select Sub Company</option>
                                            @foreach($sub_companies as $id => $entry)
                                                <option value="{{ $entry->id }}" {{ old('sub_companies_id') == $entry->id ? 'selected' : '' }}>{{ $entry->sub_company_name }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('employee'))
                                            <span class="help-block" role="alert">{{ $errors->first('employee') }}</span>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.attendance.fields.employee_helper') }}</span>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-3">
                                <div class="form-group {{ $errors->has('employee') ? 'has-error' : '' }}">
                                    <label  for="employee_id">{{ trans('cruds.attendance.fields.employee') }}</label>
                                    <select class="form-control select2" name="employee_id" id="employee_id" >
                                        <option value="">Select Employee</option>
                                        @foreach($employees as $id => $entry)
                                            <option value="{{ $entry->id }}" {{ old('employee_id') == $entry->id ? 'selected' : '' }}>{{ $entry->first_name }}( {{ $entry->employee_manual_id }} )</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('employee'))
                                        <span class="help-block" role="alert">{{ $errors->first('employee') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.attendance.fields.employee_helper') }}</span>
                                </div>
                            </div>
                            
                            <div class="col-md-6 col-sm-3">
                                <div class="form-group {{ $errors->has('branch') ? 'has-error' : '' }}">
                                    <label  for="branch">Branch</label>
                                    <select class="form-control select2" name="branch_id" id="branch" >
                                        <option value="">Select Branch</option>
                                        @foreach($branch as $id => $entry)
                                            <option value="{{ $entry->id }}" {{ old('branch_name') == $entry->id ? 'selected' : '' }}>{{ $entry->branch_name }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('branch'))
                                        <span class="help-block" role="alert">{{ $errors->first('branch') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.attendance.fields.employee_helper') }}</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="required" for="ot_date">Date</label>
                                    <input class="form-control date" placeholder="Pick Your Date" type="text" name="date" id="date" value="" required>

                                    <span class="help-block" role="alert">{{ $errors->first('from_holiday') }}</span>

                                    <span class="help-block">{{ trans('cruds.holiday.fields.from_holiday_helper') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- <button type="button" class="btn button" style="color: white;">Load</button> -->

                        <br>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="certificates">File Upload</label>
                                        <input type="file" name="csv_file" class="form-control">
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <button class="button" type="submit">
                                Search
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>


        <!-- lower table design -->

            @if(count($employeeData) > 0)
            <div class="panel">
                <div class="panel-heading">
                    <h4 style="color: #605CA8;"><b>Data List</b></h4>
                </div>
                <form method="POST" action="{{ route("admin.rosters.store") }}" enctype="multipart/form-data">
                   @csrf
                    <div class="table-responsive">
                        <table style="width:100%" class="table table-bordered table-striped table-hover" >
                            <thead class="thead-dark" style="background-color: #605CA8; color: white; font-family: serif;">
                                <tr>
                                    <th>Emp. ID</th>
                                    <th>Name</th>
                                    @foreach($dates as $key=>$date)
                                    <th style="text-align: center;" colspan="2">{{ Carbon\Carbon::parse($date)->format('d-m-Y')}}</th>
                                    @endforeach

                                    <tr style="background-color: #9e9cc9; color: #ffffff;">
                                          <th></th>
                                          <th></th>
                                        @foreach($dates as $key=>$date)
                                            <th>In</th>
                                            <th>Out</th>
                                        @endforeach
                                    </tr>
                                </tr>
                            </thead>

                            <tbody>
                           
                                @foreach($employeeData as $key=> $employee)
                                    <tr style="background-color: #e0deed;">
                                        <td rowspan="2">{{$employee->employee_manual_id}}</td>
                                        <td rowspan="2">{{$employee->first_name.' '.$employee->last_name}}</td>

                                        <tr style="background-color: #e0deed;">
                                        
                                            @foreach($dates as $key=>$date)
                                                <td>
                                                    <input type="checkbox"> Holiday
                                                    <input type="time" name="start_time[]" style="width: 70px;">
                                                    <input type="hidden" name="date[]" value="{{$date}}">
                                                    <input type="hidden" name="employee_id" value="{{$employee->id}}">
                                                </td>
                                                <td>
                                                    <br>
                                                    <input type="time" name="end_time[]" style="width: 70px;">
                                                </td>
                                            @endforeach
                                    
                                        </tr>
                                   
                                    </tr>
                                    @endforeach
                                
                            </tbody>
                        </table>

                        <div class="col-md-6 col-sm-3">
                            <div class="form-group">
                                <button class="button" type="submit">
                                    Save
                                </button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            @endif

</div>
@endsection

