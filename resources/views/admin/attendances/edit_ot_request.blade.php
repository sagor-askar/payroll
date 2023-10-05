@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Edit Overtime Request Information
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route("overtime_request.update",$ot_info->id) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('employee') ? 'has-error' : '' }}">
                                    <label class="required" for="employee_id">{{ trans('cruds.leaveApplication.fields.employee') }}</label>
                                    <select class="form-control select2" name="employee_id" id="employee_id" required>
                                        @foreach($employees as $id => $employee)
                                         <option value="{{ $employee->id }}" {{ (old('employee_id') ? old('employee_id'): $ot_info->employee->id ?? '')  == $employee->id ? 'selected' : '' }}>{{ $employee->first_name. ' '.$employee->last_name }} ({{$employee->employee_manual_id}})</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('employee'))
                                        <span class="help-block" role="alert">{{ $errors->first('employee') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.leaveApplication.fields.employee_helper') }}</span>
                                </div>
                            </div>

                            
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('date') ? 'has-error' : '' }}">
                                    <label class="required" for="date">Date</label>
                                    <input class="form-control date" type="text" name="ot_date" id="ot_date" value="{{ Carbon\Carbon::parse($ot_info->ot_date)->format('d-m-Y')}}" required>
                                    @if($errors->has('date'))
                                        <span class="help-block" role="alert">{{ $errors->first('date') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.attendance.fields.date_helper') }}</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="required" for="">Reason</label>
                                    <textarea class="form-control" type="text" placeholder="Explain Your Reason" name="reason" id="reason" required>
                                        {!! $ot_info->reason !!}
                                    </textarea>
                                    <span class="help-block">{{ trans('cruds.employee.fields.first_name_helper') }}</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="required" for="">Time (in Hour)</label>
                                    <input class="form-control" type="number" name="ot_time" id="name" value="{{$ot_info->ot_time}}" placeholder="Example: 2 " required>
                                    @if($errors->has('name'))
                                        <span class="help-block" role="alert"></span>
                                    @endif
                                    <span class="help-block"></span>
                                </div>
                            </div>

                        </div>


                        <div class="form-group">
                            <button class="button" type="submit">
                                {{ trans('global.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>



        </div>
    </div>
</div>
@endsection
