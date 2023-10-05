@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.edit') }} {{ trans('cruds.leaveApplication.title_singular') }}
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route("admin.leave-applications.update", [$leaveApplication->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                @if( $role_title  == 'Employee')
                                <div class="form-group {{ $errors->has('employee') ? 'has-error' : '' }}">
                                    <label class="required" for="employee_id">{{ trans('cruds.leaveApplication.fields.employee') }}</label>
                                    <select class="form-control select2" name="employee_id" id="employee_id" required>
                                        @foreach($user_employees as $id => $entry)
                                            <option selected value="{{ $entry->id }}" {{ (old('employee_id') ? old('employee_id') : $leaveApplication->employee->id ?? '') == $id ? 'selected' : '' }}>{{ $entry->first_name }} ({{$entry->employee_manual_id}})</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('employee'))
                                        <span class="help-block" role="alert">{{ $errors->first('employee') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.leaveApplication.fields.employee_helper') }}</span>
                                </div>

                                    <div class="form-group {{ $errors->has('assign_employee_id') ? 'has-error' : '' }}">
                                        <label class="required" for="assign_employee_id">{{ trans('cruds.leaveApplication.fields.assign_employee_id') }}</label>
                                        <select class="form-control select2" name="assign_employee_id" id="assign_employee_id" required>
                                            @foreach($assing_employees as $id => $entry)
                                                <option value="{{ $entry->id }}" {{ (old('assign_employee_id') ? old('assign_employee_id') : $leaveApplication->assign_employee->id ?? '') == $id ? 'selected' : '' }}>{{ $entry->first_name }} ({{$entry->employee_manual_id}})</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('assign_employee_id'))
                                            <span class="help-block" role="alert">{{ $errors->first('assign_employee_id') }}</span>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.leaveApplication.fields.assign_employee_id_helper') }}</span>
                                    </div>

                                    

                                    <div class="form-group {{ $errors->has('leave_type') ? 'has-error' : '' }}">
                                        <label class="required" for="leave_type_id">{{ trans('cruds.leaveApplication.fields.leave_type') }}</label>
                                        <select class="form-control select2" name="leave_type_id" id="leave_type_id" required>
                                            @foreach($leave_types as $id => $entry)
                                                <option value="{{ $id }}" {{ (old('leave_type_id') ? old('leave_type_id') : $leaveApplication->leave_type->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('leave_type'))
                                            <span class="help-block" role="alert">{{ $errors->first('leave_type') }}</span>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.leaveApplication.fields.leave_type_helper') }}</span>

                                        <div class="form-group " >
                                            <span class="showleftleave" style="color: #37a000;" > </span> &nbsp;   <span class="showtotalleave" style="color: red;" > </span>
                                        </div>
                                    </div>
                                @else

                                    <div class="form-group {{ $errors->has('company') ? 'has-error' : '' }}">
                                        <label class="required" for="company_id">{{ trans('cruds.leaveApplication.fields.company') }}</label>
                                        <select class="form-control select2" name="company_id" id="company_id" required>
                                            @foreach($companies as $id => $entry)
                                                <option value="{{ $id }}" {{ (old('company_id') ? old('company_id') : $leaveApplication->company->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('company'))
                                            <span class="help-block" role="alert">{{ $errors->first('company') }}</span>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.leaveApplication.fields.company_helper') }}</span>
                                    </div>
                                    <div class="form-group {{ $errors->has('sub_company_id') ? 'has-error' : '' }}">
                                        <label class="required" for="sub_company_id">{{ trans('cruds.leaveApplication.fields.sub_company_id') }}</label>
                                        <select class="form-control select2" name="sub_company_id" id="sub_com_id" required>
                                            @foreach($sub_companies as $id => $entry)
                                                <option value="{{ $id }}" {{ (old('sub_company_id') ? old('sub_company_id') : $leaveApplication->subcompany->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('sub_company_id'))
                                            <span class="help-block" role="alert">{{ $errors->first('sub_company_id') }}</span>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.leaveApplication.fields.sub_company_id_helper') }}</span>
                                    </div>
                                    <div class="form-group {{ $errors->has('department') ? 'has-error' : '' }}">
                                        <label class="required" for="department_id">{{ trans('cruds.leaveApplication.fields.department') }}</label>
                                        <select class="form-control select2" name="department_id" id="department_id" required>
                                            @foreach($departments as $id => $entry)
                                                <option value="{{ $id }}" {{ (old('department_id') ? old('department_id') : $leaveApplication->department->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('department'))
                                            <span class="help-block" role="alert">{{ $errors->first('department') }}</span>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.leaveApplication.fields.department_helper') }}</span>
                                    </div>

                                    <div class="form-group {{ $errors->has('employee') ? 'has-error' : '' }}">
                                        <label class="required" for="employee_id">{{ trans('cruds.leaveApplication.fields.employee') }}</label>
                                        <select class="form-control select2" name="employee_id" id="employee_id" required>
                                            @foreach($user_employees as $id => $entry)
                                                <option value="{{ $entry->id }}" {{ (old('employee_id') ? old('employee_id') : $leaveApplication->employee->id ?? '') == $id ? 'selected' : '' }}>{{ $entry->first_name }} ({{$entry->employee_manual_id}})</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('employee'))
                                            <span class="help-block" role="alert">{{ $errors->first('employee') }}</span>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.leaveApplication.fields.employee_helper') }}</span>
                                    </div>
                                    <div class="form-group {{ $errors->has('assign_employee_id') ? 'has-error' : '' }}">
                                        <label class="required" for="assign_employee_id">{{ trans('cruds.leaveApplication.fields.assign_employee_id') }}</label>
                                        <select class="form-control select2" name="assign_employee_id" id="assign_employee_id" required>
                                            @foreach($assing_employees as $id => $entry)
                                                <option value="{{ $entry->id }}" {{ (old('assign_employee_id') ? old('assign_employee_id') : $leaveApplication->assign_employee->id ?? '') == $id ? 'selected' : '' }}>{{ $entry->first_name }} ({{$entry->employee_manual_id}})</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('assign_employee_id'))
                                            <span class="help-block" role="alert">{{ $errors->first('assign_employee_id') }}</span>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.leaveApplication.fields.assign_employee_id_helper') }}</span>
                                    </div>
                                @endif

                                    <div class="form-group {{ $errors->has('approved_by') ? 'has-error' : '' }}">
                                        <label class="required" for="approved_by">{{ trans('cruds.leaveApplication.fields.approved_by') }}</label>
                                        <select class="form-control select2" name="approved_by" id="approved_by" required>
                                            @foreach($approved_employees as $id => $entry)
                                                <option selected value="{{ $entry->id }}" {{ old('approved_by') == $id ? 'selected' : '' }}>{{ $entry->first_name }} ({{$entry->employee_manual_id}})</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('approved_by'))
                                            <span class="help-block" role="alert">{{ $errors->first('approved_by') }}</span>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.leaveApplication.fields.approved_by_helper') }}</span>
                                    </div>

                            </div>
                            <div class="col-md-6">
                                @if( $role_title  == 'Employee')
                                    @else
                                    <div class="form-group {{ $errors->has('leave_type') ? 'has-error' : '' }}">
                                        <label class="required" for="leave_type_id">{{ trans('cruds.leaveApplication.fields.leave_type') }}</label>
                                        <select class="form-control select2" name="leave_type_id" id="leave_type_id" required>
                                            @foreach($leave_types as $id => $entry)
                                                <option value="{{ $id }}" {{ (old('leave_type_id') ? old('leave_type_id') : $leaveApplication->leave_type->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('leave_type'))
                                            <span class="help-block" role="alert">{{ $errors->first('leave_type') }}</span>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.leaveApplication.fields.leave_type_helper') }}</span>

                                        <div class="form-group " >
                                            <span class="showleftleave" style="color: #37a000;" > </span> &nbsp;   <span class="showtotalleave" style="color: red;" > </span>
                                        </div>
                                    </div>
                                    @endif

                                <div class="form-group {{ $errors->has('start_date') ? 'has-error' : '' }}">
                                    <label class="required" for="start_date">{{ trans('cruds.leaveApplication.fields.start_date') }}</label>
                                    <input class="form-control date" type="text" name="start_date" id="start_date" value="{{ old('start_date', $leaveApplication->start_date) }}" required>
                                    @if($errors->has('start_date'))
                                        <span class="help-block" role="alert">{{ $errors->first('start_date') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.leaveApplication.fields.start_date_helper') }}</span>
                                </div>
                                <div class="form-group {{ $errors->has('end_date') ? 'has-error' : '' }}">
                                    <label class="required" for="end_date">{{ trans('cruds.leaveApplication.fields.end_date') }}</label>
                                    <input class="form-control date" type="text" name="end_date" id="end_date" value="{{ old('end_date', $leaveApplication->end_date) }}" required>
                                    @if($errors->has('end_date'))
                                        <span class="help-block" role="alert">{{ $errors->first('end_date') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.leaveApplication.fields.end_date_helper') }}</span>
                                </div>
                                <div style="display: none" class="form-group {{ $errors->has('doc') ? 'has-error' : '' }}">
                                    <label for="doc">{{ trans('cruds.leaveApplication.fields.doc') }}</label>
                                    <div class="needsclick dropzone" id="doc-dropzone">
                                    </div>
                                    @if($errors->has('doc'))
                                        <span class="help-block" role="alert">{{ $errors->first('doc') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.leaveApplication.fields.doc_helper') }}</span>
                                </div>

                                    <div class="form-group {{ $errors->has('reason') ? 'has-error' : '' }}">
                                        <label for="reason">{{ trans('cruds.leaveApplication.fields.reason') }}</label>
                                        <textarea class="form-control" name="reason" id="reason" cols="45" rows="5">{!! $leaveApplication->reason !!}</textarea>
                                        @if($errors->has('reason'))
                                            <span class="help-block" role="alert">{{ $errors->first('reason') }}</span>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.leaveApplication.fields.reason_helper') }}</span>
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
@if(isset($leaveApplication) && $leaveApplication->doc)
      var file = {!! json_encode($leaveApplication->doc) !!}
          this.options.addedfile.call(this, file)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="doc" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
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

<script type="text/javascript">
    $(document).ready(function () {
        $(document).on('change', '#sub_com_id', function () {
            var id = $(this).val();
            $.ajax({
                type: 'get',
                url: '{{ route("admin.get_employee.department") }}',
                data: {'id': id},
                dataType: "json",
                success: function (data) {

                    if(data){
                        $('#department_id').empty();
                        $('#department_id').focus;
                        $('#department_id').append('<option value="0" required="" >Select Department </option>');
                        $.each(data, function(key, value){
                            $('select[name="department_id"]').append('<option value="'+ value.id +'">' + value.department_name+ '</option>');
                        });
                    }else{
                        $('#department_id').empty();
                    }
                },
                error: function () {

                }
            });
        });
    });
</script>


<script type="text/javascript">
    $(document).ready(function () {
        $(document).on('change', '#department_id', function () {
            var id = $(this).val();
            $.ajax({
                type: 'get',
                url: '{{ route("admin.get_reporting_employee.employee") }}',
                data: {'id': id},
                dataType: "json",
                success: function (data) {
                    if(data){
                        $('#assign_employee_id').empty();
                        $('#assign_employee_id').focus;
                        $('#assign_employee_id').append('<option value="0" required="" >Select One </option>');
                        $.each(data, function(key, value){
                            $('select[name="assign_employee_id"]').append('<option value="'+ value.id +'">' + value.first_name+' '+ value.last_name +''+value.employee_manual_id'</option>');
                        });
                    }else{
                        $('#assign_employee_id').empty();
                    }
                },
                error: function () {

                }
            });
        });
    });
</script>


<script type="text/javascript">
    $(document).ready(function () {
        $(document).on('change', '#leave_type_id', function () {
            var id = $(this).val();
            $.ajax({
                type: 'get',
                url: '{{ route("admin.get_totalleave_employee.totalleave") }}',
                data: {'id': id},
                dataType: "json",
                success: function (data) {
                    console.log(data.no_of_days);
                    if (data != null){
                        leftleavemsg = 'Total Leave : '+data.no_of_days + ' Days'
                        $(".showtotalleave ").text(leftleavemsg );
                    }else{
                        leftleavemsg = ' ' ;
                        $(".showtotalleave ").text(leftleavemsg );
                    }
                },
                error: function () {

                }
            });
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $(document).on('change', '#leave_type_id', function () {
            var id = $(this).val();
            var emp_id = $('#employee_id').val();
            $.ajax({
                type: 'get',
                url: '{{ route("admin.get_leftleave_employee.leftleave") }}',
                data: {'id': id,'emp_id':emp_id},
                dataType: "json",
                success: function (data) {
                    if (data != null){
                        leftleavemsg = 'Total Balance : '+data + ' Days'
                        $(".showleftleave ").text(leftleavemsg );
                    }else{
                        leftleavemsg = ' ' ;
                        $(".showleftleave ").text(leftleavemsg );
                    }
                },
                error: function () {

                }
            });
        });
    });
</script>
@endsection
