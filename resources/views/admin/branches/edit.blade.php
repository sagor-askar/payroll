@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.edit') }} {{ trans('cruds.branch.title_singular') }}
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route("admin.branches.update", [$branch->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="col-md-6">
                            <div class="form-group {{ $errors->has('company') ? 'has-error' : '' }}">
                                <label for="company_id">{{ trans('cruds.branch.fields.company') }}</label>
                                <select class="form-control select2" name="company_id" id="company_id">
                                    @foreach($companies as $id => $entry)
                                        <option value="{{ $id }}" {{ (old('company_id') ? old('company_id') : $branch->company->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('company'))
                                    <span class="help-block" role="alert">{{ $errors->first('company') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.branch.fields.company_helper') }}</span>
                            </div>
                            <div class="form-group {{ $errors->has('sub_company') ? 'has-error' : '' }}">
                                <label for="sub_company_id">{{ trans('cruds.branch.fields.sub_company') }}</label>
                                <select class="form-control select2" name="sub_company_id" id="sub_company_id">
                                    @foreach($sub_companies as $id => $entry)
                                        <option value="{{ $id }}" {{ (old('sub_company_id') ? old('sub_company_id') : $branch->sub_company->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('sub_company'))
                                    <span class="help-block" role="alert">{{ $errors->first('sub_company') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.branch.fields.sub_company_helper') }}</span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group {{ $errors->has('branch_name') ? 'has-error' : '' }}">
                                <label class="required" for="branch_name">{{ trans('cruds.branch.fields.branch_name') }}</label>
                                <input class="form-control" type="text" name="branch_name" id="branch_name" value="{{ old('branch_name', $branch->branch_name) }}" required>
                                @if($errors->has('branch_name'))
                                    <span class="help-block" role="alert">{{ $errors->first('branch_name') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.branch.fields.branch_name_helper') }}</span>
                            </div>
                            <div class="form-group {{ $errors->has('branch_address') ? 'has-error' : '' }}">
                                <label for="branch_address">{{ trans('cruds.branch.fields.branch_address') }}</label>
                                <input class="form-control" type="text" name="branch_address" id="branch_address" value="{{ old('branch_address', $branch->branch_address) }}">
                                @if($errors->has('branch_address'))
                                    <span class="help-block" role="alert">{{ $errors->first('branch_address') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.branch.fields.branch_address_helper') }}</span>
                            </div>
                        </div>

                        <div class="col-md-12">
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