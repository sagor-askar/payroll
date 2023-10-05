@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.edit') }} {{ trans('cruds.holiday.title_singular') }}
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route("admin.holidays.update", [$holiday->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="col-md-6">
                            <div class="form-group {{ $errors->has('company') ? 'has-error' : '' }}">
                                <label class="required" for="company_id">{{ trans('cruds.department.fields.company') }}</label>
                                <select class="form-control select2" name="company_id" id="company_id" required>
                                    {{-- @foreach($companies as $id => $entry) --}}
                                        <option value="{{ $companies->id }}" {{ (old('company_id') ? old('company_id') : $department->company->id ?? '') == $companies->id ? 'selected' : '' }}>{{ $companies->comp_name }}</option>
                                    {{-- @endforeach --}}
                                </select>
                                @if($errors->has('company'))
                                    <span class="help-block" role="alert">{{ $errors->first('company') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.department.fields.company_helper') }}</span>
                            </div>

                            <div class="form-group {{ $errors->has('department') ? 'has-error' : '' }}">
                                <label class="required" for="department_id">{{ trans('cruds.holiday.fields.department') }}</label>
                                <select class="form-control select2" name="department_id" id="department_id" required>
                                    @foreach($departments as $id => $entry)
                                        <option value="{{ $id }}" {{ (old('department_id') ? old('department_id') : $holiday->department->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('department'))
                                    <span class="help-block" role="alert">{{ $errors->first('department') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.holiday.fields.department_helper') }}</span>
                            </div>

                            <div class="form-group {{ $errors->has('holiday_name') ? 'has-error' : '' }}">
                                <label class="required" for="holiday_name">{{ trans('cruds.holiday.fields.holiday_name') }}</label>
                                <input class="form-control" type="text" name="holiday_name" id="holiday_name" value="{{ old('holiday_name', $holiday->holiday_name) }}" required>
                                @if($errors->has('holiday_name'))
                                    <span class="help-block" role="alert">{{ $errors->first('holiday_name') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.holiday.fields.holiday_name_helper') }}</span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group {{ $errors->has('from_holiday') ? 'has-error' : '' }}">
                                <label class="required" for="from_holiday">{{ trans('cruds.holiday.fields.from_holiday') }}</label>
                                <input class="form-control date" type="text" name="from_holiday" id="from_holiday" value="{{ old('from_holiday', $holiday->from_holiday) }}" required>
                                @if($errors->has('from_holiday'))
                                    <span class="help-block" role="alert">{{ $errors->first('from_holiday') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.holiday.fields.from_holiday_helper') }}</span>
                            </div>

                            <div class="form-group {{ $errors->has('to_holiday') ? 'has-error' : '' }}">
                                <label class="required" for="to_holiday">{{ trans('cruds.holiday.fields.to_holiday') }}</label>
                                <input class="form-control date" type="text" name="to_holiday" id="to_holiday" value="{{ old('to_holiday', $holiday->to_holiday) }}" required>
                                @if($errors->has('to_holiday'))
                                    <span class="help-block" role="alert">{{ $errors->first('to_holiday') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.holiday.fields.to_holiday_helper') }}</span>
                            </div>

                            <div class="form-group {{ $errors->has('number_of_days') ? 'has-error' : '' }}">
                                <label class="required" for="number_of_days">{{ trans('cruds.holiday.fields.number_of_days') }}</label>
                                <input class="form-control" type="number" name="number_of_days" id="number_of_days" value="{{ old('number_of_days', $holiday->number_of_days) }}" step="1" required>
                                @if($errors->has('number_of_days'))
                                    <span class="help-block" role="alert">{{ $errors->first('number_of_days') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.holiday.fields.number_of_days_helper') }}</span>
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