@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Edit Deduction Penalties
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route("admin.deduction-penalties.update", [$deductionPenaltiesSetup->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('employee') ? 'has-error' : '' }}">
                                    <label class="required" for="employee_id">Employee Name</label>
                                    <select class="form-control select2" name="employee_id" id="employee_id" required>
                                        @foreach($employees as $id => $employee)
                                         <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>{{ $employee->first_name. ' '.$employee->last_name }}({{$employee->employee_manual_id}})</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('employee'))
                                        <span class="help-block" role="alert">{{ $errors->first('employee') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.leaveApplication.fields.employee_helper') }}</span>
                                </div>

                                <div class="form-group {{ $errors->has('deduction') ? 'has-error' : '' }}">
                                    <label class="required" for="allowance">Deduction Amount </label>
                                    <input class="form-control" type="number" name="deduction" id="deduction" value="{{ old('deduction', $deductionPenaltiesSetup->deduction) }}" placeholder="Allowance Amount" required>
                                    @if($errors->has('deduction'))
                                        <span class="help-block" role="alert"></span>
                                    @endif
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                            <div class="form-group {{ $errors->has('additional_deduction_setup_id') ? 'has-error' : '' }}">
                                <label class="required" for="deduction_name">Deduction Name</label>
                                <select class="form-control select2" name="additional_deduction_setup_id" id="additional_deduction_setup_id" required>
                                    @foreach($deduction as $id => $entry)
                                        <option value="{{ $id }}" {{ (old('additional_deduction_setup_id') ? old('additional_deduction_setup_id') : $deductionPenaltiesSetup->additional_deduction_setup->id ?? '')  == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('additional_deduction_setup_id'))
                                    <span class="help-block" role="alert">{{ $errors->first('additional_deduction_setup_id') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.leaveApplication.fields.employee_helper') }}</span>
                            </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('deduction_date') ? 'has-error' : '' }}">
                                    <label class="required" for="deduction_date">{{ trans('cruds.attendance.fields.date') }}</label>
                                    <input class="form-control date" type="text" name="deduction_date" id="deduction_date" value="{{ old('deduction_date',\Carbon\Carbon::parse($deductionPenaltiesSetup->deduction_date)->format('d-m-Y')) }}" required>
                                    @if($errors->has('deduction_date'))
                                        <span class="help-block" role="alert">{{ $errors->first('deduction_date') }}</span>
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
