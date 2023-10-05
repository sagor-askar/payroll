@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.create') }} Training
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route("admin.training.store") }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                    <div class="form-group {{ $errors->has('trainer_id') ? 'has-error' : '' }}">
                                        <label class="required" for="trainer_id">Trainer</label>
                                        <select class="form-control select2" name="trainer_id" id="trainer_id" >
                                            <option>Please select</option>
                                            @foreach($trainers as $id => $entry)
                                                <option  value="{{ $entry->id }}">{{ $entry->name }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('trainer_id'))
                                            <span class="help-block" role="alert">{{ $errors->first('trainer_id') }}</span>
                                        @endif
                                    </div>

                                <div class="form-group {{ $errors->has('training_type_id	') ? 'has-error' : '' }}">
                                    <label class="required" for="training_type_id	">Training Type</label>
                                    <select class="form-control select2" name="training_type_id" id="training_type_id	" >
                                        <option>Please select</option>
                                        @foreach($trainer_types as $id => $entry)
                                            <option  value="{{ $entry->id }}">{{ $entry->name }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('training_type_id	'))
                                        <span class="help-block" role="alert">{{ $errors->first('training_type_id	') }}</span>
                                    @endif
                                </div>

                                <div class="form-group {{ $errors->has('training_skill_id	') ? 'has-error' : '' }}">
                                    <label class="required" for="training_skill_id	">Training Skill</label>
                                    <select class="form-control select2" name="training_skill_id" id="training_skill_id	" >
                                        <option>Please select</option>
                                        @foreach($trainer_skills as $id => $entry)
                                            <option  value="{{ $entry->id }}">{{ $entry->name }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('training_skill_id	'))
                                        <span class="help-block" role="alert">{{ $errors->first('training_skill_id	') }}</span>
                                    @endif
                                </div>
                                <div class="form-group {{ $errors->has('cost') ? 'has-error' : '' }}">
                                    <label class="required" for="cost">Training Cost</label>
                                    <input class="form-control" type="text" name="cost" id="cost" value="{{ old('cost') }}" required>
                                    @if($errors->has('cost'))
                                        <span class="help-block" role="alert">{{ $errors->first('cost') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('start_date') ? 'has-error' : '' }}">
                                    <label class="required" for="start_date">{{ trans('cruds.leaveApplication.fields.start_date') }}</label>
                                    <input class="form-control date" type="text" name="start_date" id="start_date" value="{{ old('start_date') }}" required>
                                    @if($errors->has('start_date'))
                                        <span class="help-block" role="alert">{{ $errors->first('start_date') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.leaveApplication.fields.start_date_helper') }}</span>
                                </div>
                                <div class="form-group {{ $errors->has('end_date') ? 'has-error' : '' }}">
                                    <label class="required" for="end_date">{{ trans('cruds.leaveApplication.fields.end_date') }}</label>
                                    <input class="form-control date" type="text" name="end_date" id="end_date" value="{{ old('end_date') }}" required>
                                    @if($errors->has('end_date'))
                                        <span class="help-block" role="alert">{{ $errors->first('end_date') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.leaveApplication.fields.end_date_helper') }}</span>
                                </div>

                                <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" name="description" id="description" cols="30" rows="2"></textarea>
                                    @if($errors->has('description'))
                                        <span class="help-block" role="alert">{{ $errors->first('description') }}</span>
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
                            $('select[name="assign_employee_id"]').append('<option value="'+ value.id +'">' + value.first_name+' '+ value.last_name +' '+value.employee_manual_id+'</option>');
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
