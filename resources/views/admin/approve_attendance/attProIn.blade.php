    


@extends('layouts.admin')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Attendance Processing(Last Processed date : {{ $lastAtt->date }})
                </div>
                <div class="panel-body">
                    <form action="{{ route("admin.attendanceProcessing") }}" method="POST" enctype="multiple/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                    <label class="required" for="name">Start Date</label>
                                    <input class="form-control" type="date" name="start_date" id="start_date"  required>
                                    @if($errors->has('name'))
                                        <span class="help-block" role="alert"></span>
                                    @endif
                                    <span class="help-block"></span>
                                </div>
                            </div>                           
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                    <label class="required" for="name">End Date</label>
                                    <input class="form-control" type="date" name="end_date" id="end_date"  required>
                                    @if($errors->has('name'))
                                        <span class="help-block" role="alert"></span>
                                    @endif
                                    <span class="help-block"></span>
                                </div>
                            </div>                           

                            <div class="col-md-12">
                                <div class="form-group">
                                    <button class="button" type="submit">
                                        Process Attendance
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
@parent

@endsection

