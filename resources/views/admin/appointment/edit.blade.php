@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Edit Interview Form
                </div>
                <div class="panel-body total_mark">
                    <form method="POST" action="{{ route("admin.appointment.update", [$appointment->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf

                        <div class="col-md-6 col-sm-3">
                            <div class="form-group {{ $errors->has('candidate_id') ? 'has-error' : '' }}">
                                <label class="required" for="candidate_id">Applicant Name</label>

                                <select class="form-control select2" name="interview_result_id" id="interview_result_id" required>
                                    <option selected>Please select</option>
                                    @foreach($interview_result as $key => $result)
                                        <option value="{{ $result->id }}" {{ (old('interview_result_id') ? old('interview_result_id') : $appointment->interview_result_candidate->id ?? '') == $result->id ? 'selected' : '' }}>{{ $result->candidate->name }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('interview_result_id'))
                                    <span class="help-block" role="alert">{{ $errors->first('interview_result_id') }}</span>
                                @endif

                            </div>
                        </div>

                        <div class="col-md-6 col-sm-3">

                            <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                                <label for="status">Status</label>
                                <select class="form-control select2" name="status" id="status">
                                    <option value=""> Select One</option>
                                    <option value="0" @if($appointment->status == 0) selected @endif>Send</option>
                                    <option  value="1" @if($appointment->status == 1) selected @endif>Confirmed</option>
                                </select>

                                @if($errors->has('status'))
                                    <span class="help-block" role="alert">{{ $errors->first('status') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.branch.fields.sub_company_helper') }}</span>
                            </div>
                        </div>


                        <div class="col-md-6 col-sm-3">
                            <div class="form-group {{ $errors->has('appointment_checklist_id') ? 'has-error' : '' }}">
                            <h4>Custom Questions ?</h4>
                            @foreach($checklist as $key=> $result )
                                @if(in_array($result->id, $appointment_documents))
                                    <div class="form-check custom-checkbox">
                                        <input checked type="checkbox" class="form-check-input " name="appointment_checklist[]" value="{{$result->id}} " id="custom_question_1">
                                        <label class="form-check-label" for="custom_question_1">{{$result->name}}</label>
                                    </div>
                                @else
                                    <div class="form-check custom-checkbox">
                                        <input  type="checkbox" class="form-check-input " name="appointment_checklist[]" value="{{$result->id}} " id="custom_question_1">
                                        <label class="form-check-label" for="custom_question_1">{{$result->name}}</label>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        </div>


                        <div class="col-md-12 col-sm-3">
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

@section('scripts')


    <script type="text/javascript">
        $(document).ready(function () {
            $(document).on('change', '#candidate_id', function () {
                var id = $(this).val();
                $.ajax({
                    type: 'get',
                    url: '{{ route("admin.get_candidate.find_job") }}',
                    data: {'id': id},
                    dataType: "json",
                    success: function (data) {
                        if(data){
                            $('#job_id').empty();
                            $('#job_id').focus;
                            $('#job_name').val(data['job'].job_title);
                            $('input[name="job_id"]').val(data['job'].id);
                            $('input[name="interview_date"]').val(data['interview_date']);
                        }else{
                            $('#job_name').empty();
                            $('#interview_date').empty();
                        }
                    },
                    error: function () {
                    }
                });
            });
        });
    </script>
@endsection
