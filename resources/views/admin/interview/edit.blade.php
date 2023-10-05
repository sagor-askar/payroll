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
                    <form method="POST" action="{{ route("admin.interview.update", [$interview_result->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf

                        <div class="col-md-6 col-sm-3">
                            <div class="form-group {{ $errors->has('candidate_id') ? 'has-error' : '' }}">
                                <label class="required" for="candidate_id">Candidate Name</label>
                                <input type="hidden" name="candidate_id" value="{{$interview_result->candidate_id}}">
                                <input  readonly class="form-control"  type="text"  id="candidate_id" value="{{$interview_result->candidate->name}}">
                                @if($errors->has('candidate_id'))
                                    <span class="help-block" role="alert">{{ $errors->first('candidate_id') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.leaveApplication.fields.employee_helper') }}</span>
                            </div>

                            <div class="form-group">
                                <label class="required" for="interview_date">Interview Date</label>
                                <input class="form-control" placeholder="" type="text" name="interview_date" id="interview_date" value="{{ old('interview_date',$interview_result->interview_date) }}" required>
                                <span class="help-block" role="alert">{{ $errors->first('interview_date') }}</span>
                            </div>

                            <div class="form-group">
                                <label class="required" for="viva_marks">Viva Marks</label>
                                <input class="form-control getAmount" placeholder="" type="text" name="viva_marks" id="viva_marks" value="{{ old('viva_marks',$interview_result->viva_marks) }}" required>
                                <span class="help-block" role="alert">{{ $errors->first('viva_marks') }}</span>
                            </div>

                            <div class="form-group">
                                <label class="required" for="mcq_marks">MCQ Marks</label>
                                <input class="form-control getAmount" placeholder="" type="text" name="mcq_marks" id="mcq_marks" value="{{ old('mcq_marks',$interview_result->mcq_marks) }}" required>
                                <span class="help-block" role="alert">{{ $errors->first('mcq_marks') }}</span>
                            </div>

                            <div class="form-group">
                                <label class="required" for="recommandation">Recommandation</label>
                                <input class="form-control" placeholder="" type="text" name="recommandation" id="recommandation" value="{{ old('recommandation',$interview_result->recommandation) }}" required>
                                <span class="help-block" role="alert">{{ $errors->first('recommandation') }}</span>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-3">
                            <div class="form-group {{ $errors->has('job_position') ? 'has-error' : '' }}">
                                <label class="required" for="job_position">Job Position</label>
                                <input type="hidden" name="job_id" id="job_id" value="{{ $interview_result->job_id }}">
                                <input readonly class="form-control" type="text" id="job_name" value="{{ $interview_result->job->job_title }}">
                                @if($errors->has('job_position'))
                                    <span class="help-block" role="alert">{{ $errors->first('job_position') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.leaveApplication.fields.employee_helper') }}</span>
                            </div>

                            <div class="form-group">
                                <label class="required" for="interviewer">Interviewer</label>
                                <input class="form-control" placeholder="" type="text" name="interviewer" id="interviewer" value="{{ old('interviewer',$interview_result->interviewer) }}" required>
                                <span class="help-block" role="alert">{{ $errors->first('interviewer') }}</span>
                            </div>

                            <div class="form-group">
                                <label class="required" for="written_marks">Written Marks</label>
                                <input class="form-control getAmount" placeholder="" type="text" name="written_marks" id="written_marks" value="{{ old('written_marks',$interview_result->written_marks) }}" required>
                                <span class="help-block" role="alert">{{ $errors->first('written_marks') }}</span>
                            </div>

                            <div class="form-group">
                                <label class="required" for="total_marks">Total Marks</label>
                                <input class="form-control totalAmount" placeholder="" type="text" name="total_marks" id="total_marks" value="{{ old('total_marks',$interview_result->total_marks) }}" required>
                                <span class="help-block" role="alert">{{ $errors->first('total_marks') }}</span>
                            </div>

                            <div class="form-group" {{ $errors->has('status') ? 'has-error' : '' }}">
                                <label class="required" for="status">Status</label>
                                <select class="form-control" name="status" id="status">
                                    <option value="active">Please Select</option>
                                    <option  value="1" {{ (old('status') ? old('status') : $interview_result->status ?? '') == 1 ? 'selected' : '' }}>Selected</option>
                                    <option value="0" {{ (old('status') ? old('status') : $interview_result->status ?? '') == 0 ? 'selected' : '' }}>Not Selected</option>
                                </select>
                            </div>

                </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="required" for="details">Details</label>
                                <input class="form-control" placeholder="" type="text" name="details" id="details" value="{{ old('details',$interview_result->details) }}" required>
                                <span class="help-block" role="alert">{{ $errors->first('details') }}</span>
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
            $('.total_mark').on('input', '.getAmount', function(event) {
                var total = 0;
                $('.getAmount').each(function() {
                    total += parseInt(this.value, 10) || 0;
                });
                $('.totalAmount').val(total);
            })
        });
    </script>

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
