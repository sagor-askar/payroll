@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Edit Additional Allowance
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route("admin.additional-allowance.update", [$additionalAllowanceSetup->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('company') ? 'has-error' : '' }}">
                                    <label class="required" for="company_id">Company</label>
                                    <select class="form-control select2" name="company_id" id="company_id" required>
                                        @foreach($companies as $id => $entry)
                                            <option value="{{ $id }}" {{ (old('company_id') ? old('company_id') : $additionalAllowanceSetup->company->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
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
                                            <option value="{{ $id }}" {{ (old('sub_company_id') ? old('sub_company_id'): $additionalAllowanceSetup->sub_company->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('sub_company_id'))
                                        <span class="help-block" role="alert">{{ $errors->first('sub_company_id') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.leaveType.fields.sub_company_id_helper') }}</span>
                                </div>

                            </div>

                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('allowance_name') ? 'has-error' : '' }}">
                                    <label class="required" for="allowance_name">Allowance Name</label>
                                    <input class="form-control" type="text" name="allowance_name" id="allowance_name" value="{{ old('allowance_name', $additionalAllowanceSetup->allowance_name) }}" required>
                                    @if($errors->has('allowance_name'))
                                        <span class="help-block" role="alert">{{ $errors->first('allowance_name') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.leaveType.fields.leave_name_helper') }}</span>
                                </div>

                               
                                <div class="form-group" {{ $errors->has('status') ? 'has-error' : '' }}">
                                    <label class="required" for="status">Status</label>
                                    <select class="form-control" name="status" id="status">
                                        <option value="active">Please Select</option>
                                        <option  value="1" {{ (old('status') ? old('status') : $additionalAllowanceSetup->status ?? '') == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ (old('status') ? old('status') : $additionalAllowanceSetup->status ?? '') == 0 ? 'selected' : '' }}>Inactive</option>
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
