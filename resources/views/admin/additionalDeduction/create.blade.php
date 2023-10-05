@extends('layouts.admin')
@section('content')
<div class="content">
   
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Create Additional Deduction
                </div>
                <div class="panel-body">
                    <form action="{{ route("admin.additional-deduction.store") }}" method="POST" enctype="multiple/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('company') ? 'has-error' : '' }}">
                                    <label for="company_id">Company</label>
                                    <select class="form-control select2" name="company_id" id="company_id">
                                        {{-- @foreach($companies as $id => $entry) --}}
                                            <option value="{{ $companies->id }}" {{ old('company_id') == $companies->id ? 'selected' : '' }}>{{ $companies->comp_name }}</option>
                                        {{-- @endforeach --}}
                                    </select>
                                    @if($errors->has('company'))
                                        <span class="help-block" role="alert">{{ $errors->first('company') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.subCompany.fields.company_helper') }}</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('sub_company_id') ? 'has-error' : '' }}">
                                    <label class="required" for="sub_company_id">Sub Company</label>
                                    <select class="form-control select2" name="sub_company_id" id="sub_com_id" required>
                                        @foreach($sub_companies as $id => $entry)
                                            <option value="{{ $id }}" {{ old('sub_company_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('sub_company_id'))
                                        <span class="help-block" role="alert">{{ $errors->first('sub_company_id') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.leaveApplication.fields.sub_company_id_helper') }}</span>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                    <label class="required" for="name">Deduction Name</label>
                                    <input class="form-control" type="text" name="deduction_name" id="name" value="" placeholder="Name" required>
                                    @if($errors->has('name'))
                                        <span class="help-block" role="alert"></span>
                                    @endif
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="required" for="date">Status</label>
                                    <select class="form-control" name="status" id="status">
                                        <option value="active">Please Select</option>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select> 
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
