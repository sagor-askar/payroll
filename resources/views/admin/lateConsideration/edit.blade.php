@extends('layouts.admin')
@section('content')
    <div class="content">

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                      Late Consideration Update Form
                    </div>
                    <div class="panel-body">
                        <form method="POST" action="{{ route("admin.late-consideration.update", [$lateConsider->id]) }}" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    @if( $role_title  == 'Employee')
                                        <div class="form-group {{ $errors->has('employee') ? 'has-error' : '' }}">
                                            <label class="required" for="employee_id">{{ trans('cruds.leaveApplication.fields.employee') }}</label>
                                            <select class="form-control select2" name="employee_id" id="employee_id" required>
                                                @foreach($employees as $id => $entry)
                                                    <option selected value="{{ $entry->id }}" {{ (old('employee_id') ? old('employee_id') : $lateConsider->employee->id ?? '') == $entry->id ? 'selected' : '' }}>{{ $entry->first_name.' '.$entry->last_name }} ({{$entry->employee_manual_id}})</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('employee'))
                                                <span class="help-block" role="alert">{{ $errors->first('employee') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.leaveApplication.fields.employee_helper') }}</span>
                                        </div>
                                    @else
                                        <div class="form-group {{ $errors->has('employee') ? 'has-error' : '' }}">
                                            <label class="required" for="employee_id">{{ trans('cruds.leaveApplication.fields.employee') }}</label>
                                            <select class="form-control select2" name="employee_id" id="employee_id" required>
                                                @foreach($employees as $id => $entry)
                                                    <option  value="{{ $entry->id }}" {{ (old('employee_id') ? old('employee_id') : $lateConsider->employee->id ?? '') == $entry->id ? 'selected' : '' }}>{{ $entry->first_name.' '.$entry->last_name }} ({{$entry->employee_manual_id}})</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('employee'))
                                                <span class="help-block" role="alert">{{ $errors->first('employee') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.leaveApplication.fields.employee_helper') }}</span>
                                        </div>
                                    @endif
                                        <div class="form-group {{ $errors->has('reason') ? 'has-error' : '' }}">
                                            <label for="reason">{{ trans('cruds.leaveApplication.fields.reason') }}</label>
                                            <textarea class="form-control" name="reason" id="reason" cols="45" rows="5">{!! $lateConsider->reason !!}</textarea>
                                            @if($errors->has('reason'))
                                                <span class="help-block" role="alert">{{ $errors->first('reason') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.leaveApplication.fields.reason_helper') }}</span>
                                        </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group {{ $errors->has('start_date') ? 'has-error' : '' }}">
                                        <label class="required" for="start_date">Date</label>
                                        <input class="form-control date" type="text" name="date" id="date" value="{{ old('date', $lateConsider->date) }}" required>
                                        @if($errors->has('start_date'))
                                            <span class="help-block" role="alert">{{ $errors->first('start_date') }}</span>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.leaveApplication.fields.start_date_helper') }}</span>
                                    </div>

                                    <div class="form-group {{ $errors->has('approved_by') ? 'has-error' : '' }}">
                                        <label class="required" for="approved_by">{{ trans('cruds.leaveApplication.fields.approved_by') }}</label>
                                        <select class="form-control select2" name="approved_by" id="approved_by" required>
                                            @foreach($approved_employees as $id => $entry)
                                                <option selected value="{{ $entry->id }}" {{ old('approved_by') == $entry->id ? 'selected' : '' }}>{{ $entry->first_name.' '.$entry->last_name }} ({{$entry->employee_manual_id}})</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('approved_by'))
                                            <span class="help-block" role="alert">{{ $errors->first('approved_by') }}</span>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.leaveApplication.fields.approved_by_helper') }}</span>
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
