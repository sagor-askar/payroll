@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.edit') }} {{ trans('cruds.subCompany.title_singular') }}
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route("admin.sub-companies.update", [$subCompany->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="col-md-6">
                            <div class="form-group {{ $errors->has('company') ? 'has-error' : '' }}">
                                <label for="company_id">{{ trans('cruds.subCompany.fields.company') }}</label>
                                <select class="form-control select2" name="company_id" id="company_id">
                                    {{-- @foreach($companies as $id => $entry) --}}
                                        <option value="{{ $companies->id }}" {{ (old('company_id') ? old('company_id') : $subCompany->company->id ?? '') == $companies->id ? 'selected' : '' }}>{{ $companies->comp_name }}</option>
                                    {{-- @endforeach --}}
                                </select>
                                @if($errors->has('company'))
                                    <span class="help-block" role="alert">{{ $errors->first('company') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.subCompany.fields.company_helper') }}</span>
                            </div>
                            <div class="form-group {{ $errors->has('sub_company_name') ? 'has-error' : '' }}">
                                <label class="required" for="sub_company_name">{{ trans('cruds.subCompany.fields.sub_company_name') }}</label>
                                <input class="form-control" type="text" name="sub_company_name" id="sub_company_name" value="{{ old('sub_company_name', $subCompany->sub_company_name) }}" required>
                                @if($errors->has('sub_company_name'))
                                    <span class="help-block" role="alert">{{ $errors->first('sub_company_name') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.subCompany.fields.sub_company_name_helper') }}</span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group {{ $errors->has('sub_company_address') ? 'has-error' : '' }}">
                                <label class="required" for="sub_company_address">{{ trans('cruds.subCompany.fields.sub_company_address') }}</label>
                                <input class="form-control" type="text" name="sub_company_address" id="sub_company_address" value="{{ old('sub_company_address', $subCompany->sub_company_address) }}" required>
                                @if($errors->has('sub_company_address'))
                                    <span class="help-block" role="alert">{{ $errors->first('sub_company_address') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.subCompany.fields.sub_company_address_helper') }}</span>
                            </div>
                            <div class="form-group {{ $errors->has('contact_no') ? 'has-error' : '' }}">
                                <label for="contact_no">{{ trans('cruds.subCompany.fields.contact_no') }}</label>
                                <input class="form-control" type="number" name="contact_no" id="contact_no" value="{{ old('contact_no', $subCompany->contact_no) }}">
                                @if($errors->has('contact_no'))
                                    <span class="help-block" role="alert">{{ $errors->first('contact_no') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.subCompany.fields.contact_no_helper') }}</span>
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
