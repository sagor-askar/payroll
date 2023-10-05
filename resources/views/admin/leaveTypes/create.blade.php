@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.create') }} {{ trans('cruds.leaveType.title_singular') }}
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route("admin.leave-types.store") }}" enctype="multipart/form-data">
                        @csrf
                         <div class="row">
                             <div class="col-md-6">
                                <div class="form-group {{ $errors->has('company') ? 'has-error' : '' }}">
                                    <label for="company_id">{{ trans('cruds.subCompany.fields.company') }}</label>
                                    <select class="form-control select2" name="company_id" id="company_id">
                                        <option value="">Select Company</option>
                                        {{-- @foreach($companies as $id => $entry) --}}
                                            <option value="{{ $companies->id }}" {{ old('company_id') == $companies->id ? 'selected' : '' }}>{{ $companies->comp_name }}</option>
                                        {{-- @endforeach --}}
                                    </select>
                                    @if($errors->has('company'))
                                        <span class="help-block" role="alert">{{ $errors->first('company') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.subCompany.fields.company_helper') }}</span>
                                </div>

                                 <div class="form-group {{ $errors->has('sub_company_id') ? 'has-error' : '' }}">
                                     <label class="required" for="sub_company_id">{{ trans('cruds.leaveType.fields.sub_company_id') }}</label>
                                     <select class="form-control select2" name="sub_company_id" id="sub_company_id" required>
                                         @foreach($sub_companies as $id => $entry)
                                             <option value="{{ $id }}" {{ old('sub_company_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                         @endforeach
                                     </select>
                                     @if($errors->has('sub_company_id'))
                                         <span class="help-block" role="alert">{{ $errors->first('sub_company_id') }}</span>
                                     @endif
                                     <span class="help-block">{{ trans('cruds.leaveType.fields.sub_company_id_helper') }}</span>
                                 </div>

                             </div>
                             <div class="col-md-6">
                                 <div class="form-group {{ $errors->has('leave_name') ? 'has-error' : '' }}">
                                     <label class="required" for="leave_name">{{ trans('cruds.leaveType.fields.leave_name') }}</label>
                                     <input class="form-control" placeholder="Enter Leave Name" type="text" name="leave_name" id="leave_name" value="{{ old('leave_name', '') }}" required>
                                     @if($errors->has('leave_name'))
                                         <span class="help-block" role="alert">{{ $errors->first('leave_name') }}</span>
                                     @endif
                                     <span class="help-block">{{ trans('cruds.leaveType.fields.leave_name_helper') }}</span>
                                 </div>

                                 <div class="form-group {{ $errors->has('no_of_days') ? 'has-error' : '' }}">
                                     <label class="required" for="no_of_days">{{ trans('cruds.leaveType.fields.no_of_days') }}</label>
                                     <input class="form-control" placeholder="Enter No. of Days" type="number" name="no_of_days" id="no_of_days" value="{{ old('no_of_days', '') }}" required>
                                     @if($errors->has('no_of_days'))
                                         <span class="help-block" role="alert">{{ $errors->first('no_of_days') }}</span>
                                     @endif
                                     <span class="help-block">{{ trans('cruds.leaveType.fields.no_of_days_helper') }}</span>
                                 </div>
                             </div>

                         </div>



                        <div class="form-group">
                            <button class="button" type="submit" style="background-color: #605CA8;color: white;">
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
