@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.create') }} {{ trans('cruds.designation.title_singular') }}
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route("admin.designations.store") }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

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
                            </div>

                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('designation_name') ? 'has-error' : '' }}">
                                    <label class="required" for="designation_name">{{ trans('cruds.designation.fields.designation_name') }}</label>
                                    <input class="form-control" placeholder="Enter Designation Name" type="text" name="designation_name" id="designation_name" value="{{ old('designation_name', '') }}" required>
                                    @if($errors->has('designation_name'))
                                        <span class="help-block" role="alert">{{ $errors->first('designation_name') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.designation.fields.designation_name_helper') }}</span>
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