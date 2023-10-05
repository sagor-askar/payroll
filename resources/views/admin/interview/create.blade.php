@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Interview Form
                </div>
                <div class="panel-body total_mark">
                    <form method="POST" action="{{ route('admin.interview.store')  }}" enctype="multipart/form-data">
                        @csrf

                        <div class="col-md-6 col-sm-3">
                            <div class="form-group {{ $errors->has('candidate_id') ? 'has-error' : '' }}">
                                <label class="required" for="candidate_id">Candidate Name</label>

                                <select class="form-control select2" name="candidate_id" id="candidate_id" required>
                                    <option selected>Please select</option>
                                    @foreach($candidates as $id => $entry)
                                        <option value="{{ $entry->candidate_id }}">{{ $entry->candidate->name }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('candidate_id'))
                                    <span class="help-block" role="alert">{{ $errors->first('candidate_id') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.leaveApplication.fields.employee_helper') }}</span>
                            </div>

                            <div class="form-group {{ $errors->has('interview_date') ? 'has-error' : '' }}">
                                <label class="required" for="interview_date">Interview Date</label>
                                <input class="form-control date" readonly placeholder="Pick Your Date" type="text" name="interview_date" id="interview_date" value="" required>
                                @if($errors->has('interview_date'))
                                    <span class="help-block" role="alert">{{ $errors->first('interview_date') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.holiday.fields.from_holiday_helper') }}</span>
                            </div>

                            <div class="form-group {{ $errors->has('viva_marks') ? 'has-error' : '' }}">
                                <label class="required" for="viva_marks">Viva Marks</label>
                                <input class="form-control getAmount" placeholder="Enter Viva Marks" type="number" name="viva_marks" id="viva_marks" value="" step="1" required>
                                @if($errors->has('viva_marks'))
                                    <span class="help-block" role="alert">{{ $errors->first('viva_marks') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.holiday.fields.number_of_days_helper') }}</span>
                            </div>

                            <div class="form-group {{ $errors->has('mcq_marks') ? 'has-error' : '' }}">
                                <label class="required" for="mcq_marks">MCQ Total Marks</label>
                                <input class="form-control getAmount" placeholder="MCQ Marks" type="number" name="mcq_marks" id="mcq_marks" value="" step="1" required>
                                @if($errors->has('mcq_marks'))
                                    <span class="help-block" role="alert">{{ $errors->first('mcq_marks') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.holiday.fields.number_of_days_helper') }}</span>
                            </div>

                            <div class="form-group {{ $errors->has('recommandation') ? 'has-error' : '' }}">
                                <label class="required" for="recommandation">Recommandation</label>
                                <input class="form-control" placeholder="Recommandation" type="text" name="recommandation" id="recommandation" value="" step="1" required>
                                @if($errors->has('recommandation'))
                                    <span class="help-block" role="alert">{{ $errors->first('recommandation') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.holiday.fields.number_of_days_helper') }}</span>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-3">
                            <div class="form-group {{ $errors->has('job_id') ? 'has-error' : '' }}">
                                <label for="job_id">Job Position</label>
                                <input type="hidden" name="job_id" id="job_id">
                                <input readonly class="form-control" type="text" id="job_name">
                                @if($errors->has('job_id'))
                                    <span class="help-block" role="alert">{{ $errors->first('job_id')  }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.holiday.fields.number_of_days_helper') }}</span>
                            </div>

                            <div class="form-group {{ $errors->has('interviewer') ? 'has-error' : '' }}">
                                <label for="interviewer">Interviewer</label>
                                <input class="form-control" placeholder="Interviewer" type="text" name="interviewer" id="interviewer" value="">
                                @if($errors->has('interviewer'))
                                    <span class="help-block" role="alert">{{ $errors->first('interviewer') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.holiday.fields.number_of_days_helper') }}</span>
                            </div>

                            <div class="form-group {{ $errors->has('written_total_mark') ? 'has-error' : '' }}">
                                <label for="written_total_mark">Written Mark</label>
                                <input class="form-control getAmount" placeholder="Written Marks" type="number" name="written_marks" id="written_marks" value="" step="1">
                                @if($errors->has('written_marks'))
                                    <span class="help-block" role="alert">{{ $errors->first('written_marks') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.holiday.fields.number_of_days_helper') }}</span>
                            </div>

                            <div class="form-group {{ $errors->has('total_marks') ? 'has-error' : '' }}">
                                <label for="total_marks">Total Mark</label>
                                <input readonly class="form-control totalAmount" placeholder="Total Marks" type="number" name="total_marks" id="total_marks" value="" step="1">
                                @if($errors->has('total_marks'))
                                    <span class="help-block" role="alert">{{ $errors->first('total_marks') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.holiday.fields.number_of_days_helper') }}</span>
                            </div>

                            <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                                <label for="status">Selection</label>
                                <select class="form-control select2" name="status" id="status">
                                    <option value=""> Select One</option>
                                    <option value="1"> Selected</option>
                                    <option value="0"> Not Selected</option>
                                </select>
                                @if($errors->has('status'))
                                    <span class="help-block" role="alert">{{ $errors->first('status') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.branch.fields.sub_company_helper') }}</span>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group {{ $errors->has('details') ? 'has-error' : '' }}">
                                <label class="required" for="details">Details</label>
                                <textarea class="form-control" placeholder="Details" type="text" name="details" id="details" value="" step="1" required> </textarea>
                                @if($errors->has('details'))
                                    <span class="help-block" role="alert">{{ $errors->first('details') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.holiday.fields.number_of_days_helper') }}</span>
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
