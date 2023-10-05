@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Edit Late Deduction
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route("admin.late-deduction.update", [$lateDeductionRules->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('company') ? 'has-error' : '' }}">
                                    <label class="required" for="company_id">Company</label>
                                    <select class="form-control select2" name="company_id" id="company_id" required>
                                        @foreach($companies as $id => $entry) 
                                            <option value="{{ $id }}" {{ (old('company_id') ? old('company_id') : $lateDeductionRules->company->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('company'))
                                        <span class="help-block" role="alert">{{ $errors->first('company') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.leaveType.fields.company_helper') }}</span>
                                </div>

                                <div class="form-group {{ $errors->has('sub_company_id') ? 'has-error' : '' }}">
                                    <label class="required" for="sub_company_id">Sub-Company</label>
                                    <select class="form-control select2" name="sub_company_id" id="sub_company_id" required>
                                        @foreach($sub_companies as $id => $entry)
                                            <option value="{{ $id }}" {{ (old('sub_company_id') ? old('sub_company_id'): $lateDeductionRules->sub_company->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('sub_company_id'))
                                        <span class="help-block" role="alert">{{ $errors->first('sub_company_id') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.leaveType.fields.sub_company_id_helper') }}</span>
                                </div>
                            </div>
                            

                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('late_days') ? 'has-error' : '' }}">
                                    <label class="required" for="late_days">Late Count Days </label>
                                    <input class="form-control" type="number" name="late_days" id="late_days" value="{{$lateDeductionRules->late_days}}" placeholder="Ex: 3" required>
                                    <span class="help-block" role="alert"></span>
                                </div>

                                <div class="form-group {{ $errors->has('deduction_days') ? 'has-error' : '' }}">
                                    <label class="required" for="deduction_days">Salary Deducted For </label>
                                    <input class="form-control" type="number" name="deduction_days" id="deduction_days" value="{{$lateDeductionRules->deduction_days}}" placeholder="Ex: 1" required>
                                    <span class="help-block" role="alert"></span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('salary_allowance_id') ? 'has-error' : '' }}">
                                    <label class="required" for="allowance_name">Allowance Name</label>

                                    <select class="form-control select2" name="salary_allowance_id" id="salary_allowance_id" required>
                                        <option value="">Select One</option>
                                        @foreach($allowance as $id => $entry)
                                            <option value="{{ $id }}" {{ (old('salary_allowance_id') ? old('salary_allowance_id') : $lateDeductionRules->salary_allowance->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                        @endforeach
                                    </select>

                                    @if($errors->has('salary_allowance_id'))
                                        <span class="help-block" role="alert">{{ $errors->first('salary_allowance_id') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.leaveApplication.fields.employee_helper') }}</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="required" for="date">Status</label>
                                    <select class="form-control" name="status" id="status">
                                        <option value="active">Please Select</option>
                                        <option  value="1" {{ (old('status') ? old('status') : $lateDeductionRules->status ?? '') == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ (old('status') ? old('status') : $lateDeductionRules->status ?? '') == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select> 
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
