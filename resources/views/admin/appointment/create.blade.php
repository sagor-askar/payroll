@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Create Appointment Documents
                </div>
                <div class="panel-body total_mark">
                    <form method="POST" action="{{ route('admin.appointment.store')  }}" enctype="multipart/form-data">
                        @csrf

                        <div class="col-md-6 col-sm-3">
                            <div class="form-group {{ $errors->has('candidate_id') ? 'has-error' : '' }}">
                                <label class="required" for="candidate_id">Applicant Name</label>

                                <select class="form-control select2" name="interview_result_id" id="interview_result_id" required>
                                    <option selected>Please select</option>
                                    @foreach($interview_result as $key => $result)
                                        <option value="{{ $result->id }}">{{ $result->candidate->name }}</option>
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
                                    <option value="1"> Confirmed</option>
                                    <option value="0">Send</option>
                                </select>
                                @if($errors->has('status'))
                                    <span class="help-block" role="alert">{{ $errors->first('status') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.branch.fields.sub_company_helper') }}</span>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-3">
                        <div class="form-group {{ $errors->has('appointment_checklist_id') ? 'has-error' : '' }}">
                            <h4>Applicant needs Documents?</h4>
                            @foreach($checklist as $key=> $result )
                                <div class="form-check custom-checkbox">
                                    <input type="checkbox" class="form-check-input" name="appointment_checklist[]" value="{{$result->id}}" id="appointment_checklist">
                                    <label class="form-check-label" for="appointment_checklist">{{$result->name}}</label>
                                </div>
                            @endforeach
                        </div>
                     </div>
                        <br>

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
