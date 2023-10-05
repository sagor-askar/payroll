@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Create Allowance Distribution
                </div>
                <div class="panel-body">
                    <form action="{{ route("admin.allowance-distribution.store") }}" method="POST" enctype="multiple/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('employee') ? 'has-error' : '' }}">
                                    <label class="required" for="employee_id">{{ trans('cruds.leaveApplication.fields.employee') }}</label>
                                    <select class="form-control select2" name="employee_id" id="employee_id" required>
                                        <option value="">Select One</option>
                                        @foreach($employees as $id => $employee)
                                         <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>{{ $employee->first_name. ' '.$employee->last_name }}({{$employee->employee_manual_id}})</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('employee'))
                                        <span class="help-block" role="alert">{{ $errors->first('employee') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.leaveApplication.fields.employee_helper') }}</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('additional_allowance_setup_id') ? 'has-error' : '' }}">
                                    <label class="required" for="allowance_name">Allowance Name</label>

                                    <select class="form-control select2" name="additional_allowance_setup_id" id="additional_allowance_setup_id" required>
                                    <option value="">Select One</option>
                                        @foreach($allowance as $id => $entry)
                                            <option value="{{ $id }}" {{ old('additional_allowance_setup_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                        @endforeach
                                    </select>

                                    @if($errors->has('additional_allowance_setup_id'))
                                        <span class="help-block" role="alert">{{ $errors->first('additional_allowance_setup_id') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.leaveApplication.fields.employee_helper') }}</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('allowance') ? 'has-error' : '' }}">
                                    <label class="required" for="name">Allowance Amount </label>
                                    <input class="form-control" type="number" name="allowance" id="allowance" value="" placeholder="Allowance Amount" required>
                                    @if($errors->has('allowance'))
                                        <span class="help-block" role="alert"></span>
                                    @endif
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('allowance_date') ? 'has-error' : '' }}">
                                    <label class="required" for="allowance_date">{{ trans('cruds.attendance.fields.date') }}</label>
                                    <input class="form-control date" type="text" name="allowance_date" id="allowance_date" value="{{ old('allowance_date') }}" required>
                                    @if($errors->has('allowance_date'))
                                        <span class="help-block" role="alert">{{ $errors->first('allowance_date') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.attendance.fields.date_helper') }}</span>
                                </div>
                            </div>




                            <div class="col-md-12">
                                <div class="form-group">
                                    <button class="button" type="submit">
                                        {{ trans('global.save') }}
                                    </button>
                                </div>
                            </div>


                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent





@endsection
