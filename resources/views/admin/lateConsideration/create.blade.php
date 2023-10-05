@extends('layouts.admin')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Late Consideration Form
                </div>
                <div class="panel-body">
                    <form action="{{ route("admin.late-consideration.store") }}" method="POST" enctype="multiple/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                @if( $role_title == 'Employee')
                                <div class="form-group {{ $errors->has('employee') ? 'has-error' : '' }}">
                                    <label class="required" for="employee_id">Employee</label>
                                    <select class="form-control select2" name="employee_id" id="employee_id" required>
                                        @foreach($employees as $id => $entry)
                                            <option selected value="{{ $entry->id }}" {{ old('employee_id') == $entry->id ? 'selected' : '' }}>{{ $entry->first_name }} ({{ $entry->employee_manual_id }})</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('employee'))
                                        <span class="help-block" role="alert">{{ $errors->first('employee') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.attendance.fields.employee_helper') }}</span>
                                </div>
                             @else
                                    <div class="form-group {{ $errors->has('employee') ? 'has-error' : '' }}">
                                        <label class="required" for="employee_id">Employee</label>
                                        <select class="form-control select2" name="employee_id" id="employee_id" required>
                                            <option value="">Select One</option>
                                            @foreach($employees as $id => $entry)
                                                <option value="{{ $entry->id }}" {{ old('employee_id') == $entry->id ? 'selected' : '' }}>{{ $entry->first_name }} ({{ $entry->employee_manual_id }})</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('employee'))
                                            <span class="help-block" role="alert">{{ $errors->first('employee') }}</span>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.attendance.fields.employee_helper') }}</span>
                                    </div>
                                @endif

                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="required" for="">Date</label>
                                    <input class="form-control date" placeholder="Pick Your Date" type="text" name="date" id="date" value="{{ old('date') }}" required>

                                    <span class="help-block" role="alert">{{ $errors->first('from_holiday') }}</span>

                                    <span class="help-block">{{ trans('cruds.holiday.fields.from_holiday_helper') }}</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="required" for="">Reason</label>
                                    <textarea class="form-control" type="text" placeholder="Explain Your Reason" name="reason" id="reason" value="" required></textarea>

                                    <span class="help-block">{{ trans('cruds.employee.fields.first_name_helper') }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('employee') ? 'has-error' : '' }}">
                                    <label class="required" for="approved_by">Approved By</label>
                                    <select class="form-control select2" name="approved_by" id="approved_by" required>
                                        @foreach($approved_employees as $id => $entry)
                                            <option value="{{ $entry->id }}" {{ old('employee_id') == $entry->id ? 'selected' : '' }}>{{ $entry->first_name.' '.$entry->last_name }} ({{$entry->employee_manual_id}})</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('employee'))
                                        <span class="help-block" role="alert">{{ $errors->first('employee') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.attendance.fields.employee_helper') }}</span>
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
