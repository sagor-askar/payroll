@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.edit') }} Job Application
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route("admin.jobs.update", [$jobs->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="row" style="padding: 15px;" >
                            <div class=" panel panel-default col-md-5" style="margin-left: 30px;">
                                <div class="form-group {{ $errors->has('job_title') ? 'has-error' : '' }}">
                                    <label class="required" for="job_title"> Job Title</label>
                                    <input class="form-control" type="text" name="job_title" id="job_title" value="{{ old('job_title',$jobs->job_title) }}" required>
                                    @if($errors->has('job_title'))
                                        <span class="help-block" role="alert">{{ $errors->first('job_title') }}</span>
                                    @endif
                                </div>

                                <div class="form-group row">
                                    <div class="form-group col-md-6{{ $errors->has('department') ? 'has-error' : '' }}">
                                        <label class="required" for="department_id">{{ trans('cruds.leaveApplication.fields.department') }}</label>
                                        <select class="form-control select2" name="department_id" id="department_id" required>
                                            @foreach($departments as $id => $entry)
                                                <option value="{{ $id }}" {{ (old('department_id') ? old('department_id') : $jobs->department->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('department'))
                                            <span class="help-block" role="alert">{{ $errors->first('department') }}</span>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.leaveApplication.fields.department_helper') }}</span>
                                    </div>

                                    <div class="form-group col-md-6{{ $errors->has('job_type') ? 'has-error' : '' }}">
                                        <label class="required" for="job_type">Job Type</label>
                                        <select class="form-control select2" name="job_type" id="job_type" required>
                                            <option value="">Select One</option>
                                            <option value="0" @if($jobs->job_type == 0) selected @endif >Internship</option>
                                            <option  value="1" @if($jobs->job_type == 1) selected @endif>Parttime</option>
                                            <option  value="2" @if($jobs->job_type == 2) selected @endif>Fulltime</option>
                                            <option  value="3" @if($jobs->job_type == 3) selected @endif>Contactual</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="form-group col-md-6{{ $errors->has('no_of_positions') ? 'has-error' : '' }}">
                                        <label class="required" for="no_of_positions"> No Of Positions</label>
                                        <input class="form-control" type="number" name="no_of_positions" id="no_of_positions" value="{{ old('no_of_positions',$jobs->no_of_positions) }}" required>
                                        @if($errors->has('no_of_positions'))
                                            <span class="help-block" role="alert">{{ $errors->first('no_of_positions') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-6{{ $errors->has('circulate_status') ? 'has-error' : '' }}">
                                        <label class="required" for="circulate_status"> Circulate Status</label>
                                        <select class="form-control select2" name="circulate_status" id="circulate_status" required>
                                            <option value="0" @if($jobs->circulate_status == 0) selected @endif>Inactive</option>
                                            <option  value="1" @if($jobs->circulate_status == 1) selected @endif>Active</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="form-group col-md-6{{ $errors->has('office_time') ? 'has-error' : '' }}">
                                        <label class="required" for="office_time">Office Time</label>
                                        <input class="form-control" type="text" name="office_time" id="office_time" placeholder="9:00am - 6:00pm" value="{{ old('office_time',$jobs->office_time) }}" required>
                                        @if($errors->has('office_time'))
                                            <span class="help-block" role="alert">{{ $errors->first('office_time') }}</span>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.leaveApplication.fields.start_date_helper') }}</span>
                                    </div>
                                    <div class="form-group col-md-6{{ $errors->has('salary_range') ? 'has-error' : '' }}">
                                        <label class="required" for="salary_range">Salary Range</label>
                                        <input class="form-control" type="text" name="salary_range" id="salary_range" value="{{ old('salary_range',$jobs->salary_range) }}" required>
                                        @if($errors->has('salary_range'))
                                            <span class="help-block" role="alert">{{ $errors->first('salary_range') }}</span>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.leaveApplication.fields.end_date_helper') }}</span>
                                    </div>
                                </div>



                                <div class="form-group row">
                                    <div class="form-group col-md-6{{ $errors->has('start_date') ? 'has-error' : '' }}">
                                        <label class="required" for="start_date">{{ trans('cruds.leaveApplication.fields.start_date') }}</label>
                                        <input class="form-control date" type="text" name="start_date" id="start_date" value="{{ old('start_date',\Carbon\Carbon::parse($jobs->start_date)->format('d-m-Y')) }}" required>
                                        @if($errors->has('start_date'))
                                            <span class="help-block" role="alert">{{ $errors->first('start_date') }}</span>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.leaveApplication.fields.start_date_helper') }}</span>
                                    </div>
                                    <div class="form-group col-md-6{{ $errors->has('branch') ? 'has-error' : '' }}">
                                        <label class="required" for="end_date">{{ trans('cruds.leaveApplication.fields.end_date') }}</label>
                                        <input class="form-control date" type="text" name="end_date" id="end_date" value="{{ old('end_date',\Carbon\Carbon::parse($jobs->end_date)->format('d-m-Y')) }}" required>
                                        @if($errors->has('end_date'))
                                            <span class="help-block" role="alert">{{ $errors->first('end_date') }}</span>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.leaveApplication.fields.end_date_helper') }}</span>
                                    </div>
                                </div>

                                <div class="form-group {{ $errors->has('location') ? 'has-error' : '' }}">
                                    <label class="required" for="location"> Location</label>
                                    <input class="form-control" type="text" name="location" id="location" value="{{ old('location',$jobs->location) }}" required>
                                    @if($errors->has('location'))
                                        <span class="help-block" role="alert">{{ $errors->first('location') }}</span>
                                    @endif
                                </div>

                                <div class="form-group {{ $errors->has('skills') ? 'has-error' : '' }}">
                                    <label class="required" for="skills"> Skill Box</label>
                                    <input class="form-control" data-role="taginput" type="text" name="skills" id="skills" value="{{ old('skills',$jobs->skills) }}" required>
                                    @if($errors->has('skills'))
                                        <span class="help-block" role="alert">{{ $errors->first('skills') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="  panel panel-default col-md-6" style="float: right; margin-right: 30px;">
                                <div class="form-group row">
                                    <div class="form-group col-md-6{{ $errors->has('branch') ? 'has-error' : '' }}">
                                        <h4>Need to Ask ?</h4>
                                        <div class="form-group">
                                            @if(in_array('gender', $askarray))
                                            <div class="form-check custom-checkbox ">
                                                <input checked type="checkbox" class="form-check-input " name="need_to_ask[]" value="gender" id="check-gender">
                                                <label class="form-check-label" for="check-gender">Gender </label>
                                            </div>
                                            @else
                                                <div class="form-check custom-checkbox ">
                                                    <input  type="checkbox" class="form-check-input " name="need_to_ask[]" value="gender" id="check-gender">
                                                    <label class="form-check-label" for="check-gender">Gender </label>
                                                </div>
                                             @endif

                                                @if(in_array('dob', $askarray))
                                            <div class="form-check custom-checkbox">
                                                <input checked type="checkbox" class="form-check-input" name="need_to_ask[]" value="dob" id="check-dob">
                                                <label class="form-check-label" for="check-dob">Date Of Birth</label>
                                            </div>
                                            @else
                                                    <div class="form-check custom-checkbox">
                                                        <input type="checkbox" class="form-check-input" name="need_to_ask[]" value="dob" id="check-dob">
                                                        <label class="form-check-label" for="check-dob">Date Of Birth</label>
                                                    </div>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="form-group col-md-6">
                                        <h4>Need to show Options?</h4>
                                        <div class="form-group">
                                            @if(in_array('image', $showOptionArray))
                                                <div class="form-check custom-checkbox">
                                                    <input checked type="checkbox" class="form-check-input" name="need_to_show_option[]" value="image" id="check-gender">
                                                    <label class="form-check-label" for="check-gender">Profile Image </label>
                                                </div>
                                            @else
                                                <div class="form-check custom-checkbox">
                                                    <input  type="checkbox" class="form-check-input" name="need_to_show_option[]" value="image" id="check-gender">
                                                    <label class="form-check-label" for="check-gender">Profile Image </label>
                                                </div>
                                            @endif

                                                @if(in_array('resume', $showOptionArray))
                                                 <div class="form-check custom-checkbox">
                                                <input checked type="checkbox" class="form-check-input" name="need_to_show_option[]" value="resume" id="check-dob">
                                                <label class="form-check-label" for="check-dob">Resume</label>
                                                </div>
                                                @else
                                                    <div class="form-check custom-checkbox">
                                                        <input type="checkbox" class="form-check-input" name="need_to_show_option[]" value="resume" id="check-dob">
                                                        <label class="form-check-label" for="check-dob">Resume</label>
                                                    </div>
                                                @endif


                                                @if(in_array('cover_letter', $showOptionArray))
                                                    <div class="form-check custom-checkbox">
                                                        <input checked type="checkbox" class="form-check-input" name="need_to_show_option[]" value="cover_letter" id="check-country">
                                                        <label class="form-check-label" for="check-country">Cover Letter</label>
                                                    </div>
                                                @else
                                                    <div class="form-check custom-checkbox">
                                                        <input  type="checkbox" class="form-check-input" name="need_to_show_option[]" value="cover_letter" id="check-country">
                                                        <label class="form-check-label" for="check-country">Cover Letter</label>
                                                    </div>
                                                @endif

                                                @if(in_array('term_conditions', $showOptionArray))
                                            <div class="form-check custom-checkbox">
                                                <input checked type="checkbox" class="form-check-input" name="need_to_show_option[]" value="term_conditions" id="check-country">
                                                <label class="form-check-label" for="check-country">Terms And Conditions</label>
                                            </div>
                                                @else
                                                    <div class="form-check custom-checkbox">
                                                        <input type="checkbox" class="form-check-input" name="need_to_show_option[]" value="term_conditions" id="check-country">
                                                        <label class="form-check-label" for="check-country">Terms And Conditions</label>
                                                    </div>
                                                @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group my-4">
                                    <h4>Custom Questions?</h4>
                                    @foreach($questions as $key=> $question )
                                        @if(in_array($question->id, $customArray))
                                            <div class="form-check custom-checkbox">
                                                <input checked type="checkbox" class="form-check-input " name="custom_question[]" value="{{$question->id}} " id="custom_question_1">
                                                <label class="form-check-label" for="custom_question_1">{{$question->question}}</label>
                                            </div>
                                        @else
                                        <div class="form-check custom-checkbox">
                                            <input  type="checkbox" class="form-check-input " name="custom_question[]" value="{{$question->id}} " id="custom_question_1">
                                            <label class="form-check-label" for="custom_question_1">{{$question->question}}</label>
                                        </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="row" style="padding: 15px;">
                            <div class=" panel panel-default col-md-5" style="margin-left: 30px;">
                                <div class="form-group {{ $errors->has('job_description') ? 'has-error' : '' }}">
                                    <label for="job_description">Job Description</label>
                                    <textarea class="form-control" name="job_description"  id="descriptionstyle" cols="45" rows="5">{!! $jobs->job_description !!}</textarea>
                                    @if($errors->has('job_description'))
                                        <span class="help-block" role="alert">{{ $errors->first('job_description') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class=" col-md-6 panel panel-default" style="float: right; margin-right: 30px;">
                                <div class="form-group {{ $errors->has('job_requirement') ? 'has-error' : '' }}">
                                    <label for="job_requirement">Job Requirement</label>
                                    <textarea class="form-control" name="job_requirement" id="requirementstyle" cols="45" rows="5">{!! $jobs->job_requirement !!}</textarea>
                                    @if($errors->has('job_requirement'))
                                        <span class="help-block" role="alert">{{ $errors->first('job_requirement') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group" style="padding: 15px;margin-left: 15px;">
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
        ClassicEditor
            .create(document.querySelector('#descriptionstyle'))
            .catch(error =>{
                console.log(error);
            });
    </script>

    <script>
        ClassicEditor
            .create(document.querySelector('#requirementstyle'))
            .catch(error =>{
                console.log(error);
            });
    </script>
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
