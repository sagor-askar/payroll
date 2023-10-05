@extends('layouts.admin')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                  Provident Loan Application Form
                </div>
                <div class="panel-body">
                    <form action="{{ route("admin.provident_loan.store") }}" method="POST" enctype="multiple/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6" id="getInstalment">
                                @if( $role_title == 'Employee')
                                <div class="form-group {{ $errors->has('employee') ? 'has-error' : '' }}">
                                    <div class="form-group showmsg" style="color: #dd4b39;">
                                        <span> </span>
                                    </div>
                                    <label class="required" for="employee_id">Employee</label>
                                    <select class="form-control select2" name="employee_id" id="employee_id" required>
                                        <option value="">Select One</option>
                                        @foreach($employees as $id => $entry)
                                            <option  value="{{ $entry->id }}" {{ old('employee_id') == $entry->id ? 'selected' : '' }}>{{ $entry->first_name }} ({{ $entry->employee_manual_id }})</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('employee'))
                                        <span class="help-block" role="alert">{{ $errors->first('employee') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.attendance.fields.employee_helper') }}</span>
                                </div>
                             @else
                                    <div class="form-group {{ $errors->has('employee') ? 'has-error' : '' }}">
                                        <div class="form-group showmsg" style="color: #dd4b39;">
                                            <span> </span>
                                        </div>
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

                                    <div class="form-group">
                                        <label class="required" for="amount">Amount</label>
                                        <input class="form-control" placeholder="Loan Amount" type="number" name="amount" id="amount" value="{{ old('amount') }}" required>
                                        <span class="help-block" role="alert">{{ $errors->first('amount') }}</span>
                                    </div>

                                    <div class="form-group">
                                        <label class="required" for="installment_period">Installment Amount</label>
                                        <input class="form-control" placeholder="Instalment amount" type="number" name="installment_amount" id="installment_amount" value="{{ old('installment_amount') }}" required>
                                        <span class="help-block" role="alert">{{ $errors->first('installment_period') }}</span>
                                    </div>
                                    <div class="form-group">
                                        <label class="required" for="">Adjustment Date</label>
                                        <input class="form-control date" placeholder="Pick Adjustment Date" type="text" name="adjustment_date" id="adjustment_date" value="{{ old('adjustment_date') }}" required>
                                        <span class="help-block" role="alert">{{ $errors->first('adjustment_date') }}</span>
                                        <span class="help-block">{{ trans('cruds.holiday.fields.from_holiday_helper') }}</span>
                                    </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="required" for="">Apply Date</label>
                                    <input class="form-control date" placeholder="Pick Your Date" type="text" name="apply_date" id="apply_date" value="{{ old('apply_date') }}" required>
                                    <span class="help-block" role="alert">{{ $errors->first('apply_date') }}</span>
                                    <span class="help-block">{{ trans('cruds.holiday.fields.from_holiday_helper') }}</span>
                                </div>
                                <div class="form-group">
                                    <label class="required" for="">Loan Details</label>
                                    <textarea class="form-control" type="text" placeholder="Explain Your Reason" name="loan_details" id="loan_details" required></textarea>
                                    <span class="help-block">{{ trans('cruds.employee.fields.first_name_helper') }}</span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button class="button check_button" type="submit">
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
