@extends('layouts.admin')
@section('content')
    <div class="content">

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                  Loan Application Update Form
                    </div>
                    <div class="panel-body">
                        <form method="POST" action="{{ route("admin.provident_loan.update", [$providentLoan->id]) }}" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    @if( $role_title == 'Employee')
                                        <div class="form-group {{ $errors->has('employee') ? 'has-error' : '' }}">
                                            <label class="required" for="employee_id">Employee</label>
                                            <select class="form-control select2" name="employee_id" id="employee_id" required>
                                                @foreach($employees as $entry)
                                                    <option value="{{ $entry->id }}" {{ (old('employee_id') ? old('employee_id') : $providentLoan->employee->id ?? '') == $entry->id ? 'selected' : '' }}>{{ $entry->first_name.' '.$entry->last_name }} ({{ $entry->employee_manual_id }})</option>
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
                                                @foreach($employees as $entry)
                                                    <option value="{{ $entry->id }}" {{ (old('employee_id') ? old('employee_id') : $providentLoan->employee->id ?? '') == $entry->id ? 'selected' : '' }}>{{ $entry->first_name.' '.$entry->last_name }} ({{ $entry->employee_manual_id }})</option>
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
                                        <input class="form-control" placeholder="Loan Amount" type="text" name="amount" id="amount" value="{{ old('amount',$providentLoan->amount) }}" required>
                                        <span class="help-block" role="alert">{{ $errors->first('amount') }}</span>
                                    </div>
                                    <div class="form-group">
                                        <label class="required" for="installment_period">Installment Amount</label>
                                        <input  class="form-control" placeholder="Instalment amount" type="number" name="installment_amount" id="installment_amount" value="{{ old('installment_amount',$providentLoan->installment_amount) }}" required>
                                        <span class="help-block" role="alert">{{ $errors->first('installment_period') }}</span>
                                    </div>
                                        <div class="form-group">
                                            <label class="required" for="">Adjustment Date</label>
                                            <input class="form-control date" placeholder="Pick Adjustment Date" type="text" name="adjustment_date" id="adjustment_date" value="{{  \Carbon\Carbon::parse($providentLoan->adjustment_date)->format('d-m-Y') }}" required>
                                            <span class="help-block" role="alert">{{ $errors->first('adjustment_date') }}</span>
                                            <span class="help-block">{{ trans('cruds.holiday.fields.from_holiday_helper') }}</span>
                                        </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="required" for="">Apply Date</label>
                                        <input class="form-control date" placeholder="Pick Your Date" type="text" name="apply_date" id="apply_date" value="{{ old('apply_date',\Carbon\Carbon::parse($providentLoan->apply_date)->format('d-m-Y')) }}" required>
                                        <span class="help-block" role="alert">{{ $errors->first('apply_date') }}</span>
                                        <span class="help-block">{{ trans('cruds.holiday.fields.from_holiday_helper') }}</span>
                                    </div>
                                    <div class="form-group">
                                        <label class="required" for="">Loan Details</label>
                                        <textarea class="form-control" type="text" placeholder="Explain Your Reason" name="loan_details" id="loan_details" required>{!! $providentLoan->loan_details !!}</textarea>
                                        <span class="help-block">{{ trans('cruds.employee.fields.first_name_helper') }}</span>
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
    <script>
        Dropzone.options.docDropzone = {
            url: '{{ route('admin.leave-applications.storeMedia') }}',
            maxFilesize: 2, // MB
            maxFiles: 1,
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 2
            },
            success: function (file, response) {
                $('form').find('input[name="doc"]').remove()
                $('form').append('<input type="hidden" name="doc" value="' + response.name + '">')
            },
            removedfile: function (file) {
                file.previewElement.remove()
                if (file.status !== 'error') {
                    $('form').find('input[name="doc"]').remove()
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function () {

            },
            error: function (file, response) {
                if ($.type(response) === 'string') {
                    var message = response //dropzone sends it's own error messages in string
                } else {
                    var message = response.errors.file
                }
                file.previewElement.classList.add('dz-error')
                _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                _results = []
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    node = _ref[_i]
                    _results.push(node.textContent = message)
                }

                return _results
            }
        }
    </script>


@endsection
