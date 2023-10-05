@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.edit') }} {{ trans('cruds.weeklyHoliday.title_singular') }}
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route("admin.weekly-holidays.update", [$weeklyHoliday->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="col-md-6">
                            <div class="form-group {{ $errors->has('company') ? 'has-error' : '' }}">
                                <label class="required" for="company_id">{{ trans('cruds.weeklyHoliday.fields.company') }}</label>
                                <select class="form-control select2" name="company_id" id="company_id" required>
                                    @foreach($companies as $id => $entry)
                                        <option value="{{ $id }}" {{ (old('company_id') ? old('company_id') : $weeklyHoliday->company->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('company'))
                                    <span class="help-block" role="alert">{{ $errors->first('company') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.weeklyHoliday.fields.company_helper') }}</span>
                            </div>

                            <div class="form-group {{ $errors->has('weeklyleave') ? 'has-error' : '' }}">
                                <label class="required" for="weeklyleave">{{ trans('cruds.weeklyHoliday.fields.weeklyleave') }}</label>
                                <input class="form-control" type="text" name="weeklyleave" id="weeklyleave" value="{{ old('weeklyleave', $weeklyHoliday->weeklyleave) }}" required>
                                @if($errors->has('weeklyleave'))
                                    <span class="help-block" role="alert">{{ $errors->first('weeklyleave') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.weeklyHoliday.fields.weeklyleave_helper') }}</span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group {{ $errors->has('department') ? 'has-error' : '' }}">
                                <label class="required" for="department_id">{{ trans('cruds.weeklyHoliday.fields.department') }}</label>
                                <select class="form-control select2" name="department_id" id="department_id" required>
                                    @foreach($departments as $id => $entry)
                                        <option value="{{ $id }}" {{ (old('department_id') ? old('department_id') : $weeklyHoliday->department->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('department'))
                                    <span class="help-block" role="alert">{{ $errors->first('department') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.weeklyHoliday.fields.department_helper') }}</span>
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