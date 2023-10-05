@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.create') }} {{ trans('cruds.department.title_singular') }}
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route("admin.departments.store") }}" enctype="multipart/form-data">
                        @csrf

                        <div class="col-md-6">
                            <div class="form-group {{ $errors->has('company') ? 'has-error' : '' }}">
                                <label class="required" for="company_id">{{ trans('cruds.department.fields.company') }}</label>
                                <select class="form-control select2" name="company_id" id="company_id" required>
                                    {{-- @foreach($companies as $id => $entry) --}}
                                    <option value="{{ $companies->id }}" {{ old('company_id') == $companies->id ? 'selected' : '' }}>{{ $companies->comp_name }}</option>
                                    {{-- @endforeach --}}
                                </select>
                                @if($errors->has('company'))
                                    <span class="help-block" role="alert">{{ $errors->first('company') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.department.fields.company_helper') }}</span>
                            </div>

                            <div class="form-group {{ $errors->has('sub_company') ? 'has-error' : '' }}">
                                <label for="sub_company_id">{{ trans('cruds.department.fields.sub_company') }}</label>
                                <select class="form-control select2" name="sub_company_id" id="sub_company_id">
                                    @foreach($sub_companies as $id => $entry)
                                        <option value="{{ $id }}" {{ old('sub_company_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('sub_company'))
                                    <span class="help-block" role="alert">{{ $errors->first('sub_company') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.department.fields.sub_company_helper') }}</span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group {{ $errors->has('branch') ? 'has-error' : '' }}">
                                <label for="branch_id">{{ trans('cruds.department.fields.branch') }}</label>
                                <select class="form-control select2" name="branch_id" id="branch_id">
                                    @foreach($branches as $id => $entry)
                                        <option value="{{ $id }}" {{ old('branch_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('branch'))
                                    <span class="help-block" role="alert">{{ $errors->first('branch') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.department.fields.branch_helper') }}</span>
                            </div>

                            <div class="form-group {{ $errors->has('department_name') ? 'has-error' : '' }}">
                                <label class="required" for="department_name">{{ trans('cruds.department.fields.department_name') }}</label>
                                <input class="form-control" placeholder="Enter Department Name" type="text" name="department_name" id="department_name" value="{{ old('department_name', '') }}" required>
                                @if($errors->has('department_name'))
                                    <span class="help-block" role="alert">{{ $errors->first('department_name') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.department.fields.department_name_helper') }}</span>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <button class="button" type="submit">
                                    {{ trans('global.save') }}
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>



        </div>
    </div>
</div>
@endsection