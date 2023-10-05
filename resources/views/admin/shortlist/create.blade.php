@extends('layouts.admin')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 style="color: #605CA8;"><b>Create Candidate Interview </b></h4>
                    </div>
                    <div class="panel-body">
                        <form method="POST" action="{{ route("admin.shortlist.store") }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <div class="form-group">
                                        <div class="form-group {{ $errors->has('candidate_id') ? 'has-error' : '' }}">
                                            <label for="candidate_id"> Candidate Name</label>
                                            <input type="hidden" name="candidate_id" value="{{$candidates->id}}">
                                            <input type="hidden" name="job_id" value="{{$candidates->job_id}}">
                                            <input readonly class="form-control" type="text"  id="candidate_id" value="{{$candidates->name}}">
                                            @if($errors->has('candidate_id'))
                                                <span class="help-block" role="alert"></span>
                                            @endif
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-group {{ $errors->has('interview_date') ? 'has-error' : '' }}">
                                            <label class="required" for="interview_date">Interview  Date</label>
                                            <input class="form-control date" type="text" name="interview_date" id="interview_date" value="" required>
                                            @if($errors->has('interview_date'))
                                                <span class="help-block" role="alert"></span>
                                            @endif
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-group {{ $errors->has('interview_time') ? 'has-error' : '' }}">
                                            <label class="required" for="interview_time">Interview Time</label>
                                            <input class="form-control" type="time" name="interview_time" id="interview_time" value="{{ old('interview_time') }}" required>
                                            @if($errors->has('interview_time'))
                                                <span class="help-block" role="alert">{{ $errors->first('interview_time') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                               <div class="form-group col-md-6">
                                <div class="form-group">
                                    <div class="form-group {{ $errors->has('comment') ? 'has-error' : '' }}">
                                        <label for="comment">Comment</label>
                                        <textarea class="form-control" name="comment" id="requirementstyle" cols="45" rows="5"></textarea>
                                        @if($errors->has('comment'))
                                            <span class="help-block" role="alert">{{ $errors->first('comment') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            </div>
                            <div class="form-group">
                                <button class="button" type="submit">
                                    Apply
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
@endsection


