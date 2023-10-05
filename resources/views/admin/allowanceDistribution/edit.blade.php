@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Edit Allowance Distribution
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route("admin.allowance-distribution.update", [$allowanceDistributionSetup->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('employee') ? 'has-error' : '' }}">
                                    <label class="required" for="employee_id">{{ trans('cruds.leaveApplication.fields.employee') }}</label>
                                    <select class="form-control select2" name="employee_id" id="employee_id" required>
                                        @foreach($employees as $id => $employee)
                                         <option value="{{ $employee->id }}" {{ (old('employee_id') ? old('employee_id'): $allowanceDistributionSetup->employee->id ?? '')  == $employee->id ? 'selected' : '' }}>{{ $employee->first_name. ' '.$employee->last_name }} ({{$employee->employee_manual_id}})</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('employee'))
                                        <span class="help-block" role="alert">{{ $errors->first('employee') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.leaveApplication.fields.employee_helper') }}</span>
                                </div>

                                <div class="form-group {{ $errors->has('additional_allowance_setup_id') ? 'has-error' : '' }}">
                                    <label class="required" for="allowance_name">Allowance Name</label>
                                    <select class="form-control select2" name="additional_allowance_setup_id" id="additional_allowance_setup_id" required>
                                        @foreach($allowance as $id => $entry)
                                            <option value="{{ $id }}" {{ (old('additional_allowance_setup_id') ? old('additional_allowance_setup_id') : $allowanceDistributionSetup->additional_allowance_setup->id ?? '')   == $id ? 'selected' : '' }}>{{ $entry }}</option>
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
                                    <label class="required" for="allowance">Allowance Amount </label>
                                    <input class="form-control" type="text" name="allowance" id="allowance" value="{{ old('allowance', $allowanceDistributionSetup->allowance) }}" placeholder="Allowance Amount" required>
                                    @if($errors->has('allowance'))
                                        <span class="help-block" role="alert"></span>
                                    @endif
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('allowance_date') ? 'has-error' : '' }}">
                                    <label class="required" for="allowance_date">{{ trans('cruds.attendance.fields.date') }}</label>
                                    <input class="form-control date" type="text" name="allowance_date" id="allowance_date" value="{{ old('allowance_date',\Carbon\Carbon::parse($allowanceDistributionSetup->allowance_date)->format('d-m-Y')) }}" required>
                                    @if($errors->has('allowance_date'))
                                        <span class="help-block" role="alert">{{ $errors->first('allowance_date') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.attendance.fields.date_helper') }}</span>
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
