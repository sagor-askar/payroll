@extends('layouts.admin')
@section('content')
<div class="content">
    <style>
        .heading {
            display: none;
        }
    </style>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 style="color: #605CA8;"><b>Generate Training Report</b></h4>
                </div>
                <div class="panel-body">
                    <form id="basic-form"  method="POST" action="{{ route('admin.training_report.search') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-4">
                            <div class="form-group {{ $errors->has('employee') ? 'has-error' : '' }}">
                                <label for="employee_id">{{ trans('cruds.attendance.fields.employee') }}</label>
                                <select class="form-control select2" name="employee_id" id="employee_id">
                                    <option value="">Select One</option>
                                    @foreach($employees as $id => $entry)
                                        <option value="{{ $entry->id }}" {{ old('employee_id') == $entry->id ? 'selected' : '' }}>{{ $entry->first_name.' '.$entry->last_name }} ({{$entry->employee_manual_id}})</option>
                                    @endforeach
                                </select>
                                @if($errors->has('employee'))
                                    <span class="help-block" role="alert">{{ $errors->first('employee') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.attendance.fields.employee_helper') }}</span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group {{ $errors->has('trainer_id') ? 'has-error' : '' }}">
                                <label for="department_id">Trainer</label>
                                <select class="form-control select2" name="trainer_id" id="trainer_id">
                                    <option value="">Select One</option>
                                    @foreach($trainers as $id => $entry)
                                        <option value="{{ $entry->id }}" {{ old('trainer_id') == $entry->id ? 'selected' : '' }}>{{ $entry->name }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('trainer_id'))
                                    <span class="help-block" role="alert">{{ $errors->first('trainer_id') }}</span>
                                @endif
                            </div>
                        </div>



                        <div class="col-md-4">
                            <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                                <label  for="status">Status</label>
                                <select class="form-control select2" name="status" id="status" >
                                    <option  value="">Select one</option>
                                    <option  value="0">Pending</option>
                                    <option  value="1">Started</option>
                                    <option  value="2">Completed</option>
                                    <option  value="3">Terminated</option>
                                </select>
                                @if($errors->has('status'))
                                    <span class="help-block" role="alert">{{ $errors->first('status') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group {{ $errors->has('date') ? 'has-error' : '' }}">
                                <label for="date">From:</label>
                                <input class="form-control date" type="text" name="start_date" id="date" value="{{ old('start_date') }}">
                                @if($errors->has('date'))
                                    <span class="help-block" role="alert">{{ $errors->first('date') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.attendance.fields.date_helper') }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group {{ $errors->has('date') ? 'has-error' : '' }}">
                                <label for="date">To:</label>
                                <input class="form-control date" type="text" name="end_date" id="date" value="{{ old('date') }}">
                                @if($errors->has('date'))
                                    <span class="help-block" role="alert">{{ $errors->first('date') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.attendance.fields.date_helper') }}</span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <button class="button" id="load" data-loading-text="<i class='fas fa-circle-notch fa-spin'></i>">
                                    Search
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="myDataTable" style="display: none">
            </div>

        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            flag = true;
            $('#basic-form').submit(function(e){
                e.preventDefault();
                let formdata = $(this).serialize();
                let url  = $(this).attr('action');
                var $this = $(this);
                $this.button('loading');
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: url,
                    type: "POST",
                    data: new FormData(this),
                    dataType:'HTML',
                    contentType: false,
                    processData:false,
                    success:function(data){
                        $('.myDataTable').show();
                        $('.myDataTable').html(data);
                        $this.button('reset');
                        $('#basic-form').reset();
                    }
                });

            });
        });
    </script>
<script type="text/javascript">
    function printPageArea(printableArea) {

        var printContents = document.getElementById("printableArea").innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        window.close();
        document.body.innerHTML = originalContents;
    }

</script>

@endsection
