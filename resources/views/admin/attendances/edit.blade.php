@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.edit') }} {{ trans('cruds.attendance.title_singular') }}
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route("admin.attendances.update", [$attendance->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="row">
                          
                                <input class="form-control" type="hidden" name="id"  value="{{  $attendance->id }}">
                                @if( $role_title  == 'Employee')
                                <div class="col-md-6">
                                    <div class="form-group {{ $errors->has('employee') ? 'has-error' : '' }}">
                                        <label class="required" for="employee_id">{{ trans('cruds.attendance.fields.employee') }}</label>
                                        <select class="form-control select2" name="employee_id" id="employee_id" required>
                                            @foreach($employees as $key => $entry)
                                                <option selected value="{{ $entry->id }}" {{ (old('employee_id') ? old('employee_id') : $attendance->employee->id ?? '') == $entry->id ? 'selected' : '' }}>{{ $entry->first_name }} ({{ $entry->employee_manual_id }})</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('employee'))
                                            <span class="help-block" role="alert">{{ $errors->first('employee') }}</span>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.attendance.fields.employee_helper') }}</span>
                                    </div>
                                    <div class="form-group {{ $errors->has('date') ? 'has-error' : '' }}">
                                        <label class="required" for="date">{{ trans('cruds.attendance.fields.date') }}</label>
                                        <input class="form-control date" type="text" name="date" id="date" value="{{ old('date', $attendance->date) }}" required readonly>
                                        @if($errors->has('date'))
                                            <span class="help-block" role="alert">{{ $errors->first('date') }}</span>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.attendance.fields.date_helper') }}</span>
                                    </div>
                                 </div>
                                 <div class="col-md-6">
                                    <div class="form-group {{ $errors->has('clock_in') ? 'has-error' : '' }}">
                                        <label class="required" for="clock_in">{{ trans('cruds.attendance.fields.clock_in') }}</label>
                                        <input disabled class="form-control" type="time" name="clock_in" id="clock_in" value="{{ old('clock_in', $attendance->clock_in) }}" required>
                                        <input type="hidden" name="clock_in" id="clock_in" value="{{ old('clock_in', $attendance->clock_in) }}">
                                        @if($errors->has('clock_in'))
                                            <span class="help-block" role="alert">{{ $errors->first('clock_in') }}</span>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.attendance.fields.clock_in_helper') }}</span>
                                    </div>
                                    <div class="form-group {{ $errors->has('clock_out') ? 'has-error' : '' }}">
                                        <label class="required" for="clock_out">{{ trans('cruds.attendance.fields.clock_out') }}</label>
                                        <input class="form-control" type="text" name="clock_out" id="clock_out" value="{{ date('H:i') }}" required readonly>
                                        <input type="hidden" name="postal" id="postal" value="">
                                        @if($errors->has('clock_out'))
                                            <span class="help-block" role="alert">{{ $errors->first('clock_out') }}</span>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.attendance.fields.clock_out_helper') }}</span>
                                    </div>
                                </div>
                                @else
                                    <div class="col-md-6">
                                        <div class="form-group {{ $errors->has('employee') ? 'has-error' : '' }}">
                                            <label class="required" for="employee_id">{{ trans('cruds.attendance.fields.employee') }}</label>
                                            <select class="form-control select2" name="employee_id" id="employee_id" required>
                                                @foreach($employees as $key => $entry)
                                                    <option value="{{ $entry->id }}" {{ (old('employee_id') ? old('employee_id') : $attendance->employee->id ?? '') == $entry->id ? 'selected' : '' }}>{{ $entry->first_name }} ({{ $entry->employee_manual_id }})</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('employee'))
                                                <span class="help-block" role="alert">{{ $errors->first('employee') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.attendance.fields.employee_helper') }}</span>
                                        </div>
                                        <div class="form-group {{ $errors->has('date') ? 'has-error' : '' }}">
                                            <label class="required" for="date">{{ trans('cruds.attendance.fields.date') }}</label>
                                            <input class="form-control date" type="text" name="date" id="date" value="{{ old('date', $attendance->date) }}" required>
                                            @if($errors->has('date'))
                                                <span class="help-block" role="alert">{{ $errors->first('date') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.attendance.fields.date_helper') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group {{ $errors->has('clock_in') ? 'has-error' : '' }}">
                                            <label class="required" for="clock_in">{{ trans('cruds.attendance.fields.clock_in') }}</label>
                                            <input  class="form-control" type="time" name="clock_in" id="clock_in" value="{{ old('clock_in', $attendance->clock_in) }}" required>
                                            <input type="hidden" name="clock_in" id="clock_in" value="{{ old('clock_in', $attendance->clock_in) }}">
                                            @if($errors->has('clock_in'))
                                                <span class="help-block" role="alert">{{ $errors->first('clock_in') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.attendance.fields.clock_in_helper') }}</span>
                                        </div>
                                        <div class="form-group {{ $errors->has('clock_out') ? 'has-error' : '' }}">
                                            <label class="required" for="clock_out">{{ trans('cruds.attendance.fields.clock_out') }}</label>
                                            <input class="form-control" type="time" name="clock_out" id="clock_out" value="{{ old('clock_in', $attendance->clock_out) }}"  required>
                                            <input type="hidden" name="postal" id="postal" value="">
                                            @if($errors->has('clock_out'))
                                                <span class="help-block" role="alert">{{ $errors->first('clock_out') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.attendance.fields.clock_out_helper') }}</span>
                                        </div>
                                    </div>
                                   
                                @endif
                        </div>

                    @php
                    $todayDate = date('d-m-Y');
                    @endphp
                        @if($attendance->date == $todayDate )
                        <div class="form-group">
                            <button class="button" type="submit">
                                {{ trans('global.save') }}
                            </button>
                        </div>
                        @else
                            <div  class="form-group">
                                <button disabled class="button" type="submit">
                                    {{ trans('global.save') }}
                                </button>
                            </div>
                        @endif
                    </form>
                </div>
            </div>



        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent

@include('scripts.location_script')

@endsection
