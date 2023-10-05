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
                <div class="panel-heading" style="padding: 2px;">
                    <h4 style="color: #605CA8;"><b>Daily Absents Report</b></h4>
                </div>

                <div class="panel-body">
                    <form id="basic-form" method="POST" action="{{ route("admin.attendances.daily.absents") }}" enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-6 col-sm-3">
                            <div class="form-group {{ $errors->has('department') ? 'has-error' : '' }}">
                                <label for="department_id">{{ trans('cruds.employee.fields.department') }}</label>
                                <select class="form-control select3" name="department_id" id="department_id">
                                    @foreach($departments as $id => $entry)
                                    <option value="{{ $id }}" {{ old('department_id') == $id ? 'selected' : '' }}>
                                        {{ $entry }}
                                    </option>
                                    @endforeach
                                </select>
                                @if($errors->has('department'))
                                <span class="help-block" role="alert">{{ $errors->first('department') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.employee.fields.department_helper') }}</span>
                            </div>
                        </div>

                        <div class="col-md-6 col-ms-3">
                            <div class="form-group {{ $errors->has('date') ? 'has-error' : '' }}">
                                <label class="required" for="date">{{ trans('cruds.attendance.fields.date') }}</label>
                                <input class="form-control date" placeholder="Pick a date" type="text" name="date" id="date" value="{{ old('date') }}" required>
                                @if($errors->has('date'))
                                <span class="help-block" role="alert">{{ $errors->first('date') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.attendance.fields.date_helper') }}</span>
                            </div>
                        </div>


                        <div class="col-md-12 col-sm-3">
                            <button  class="button" id="load" data-loading-text="<i class='fas fa-circle-notch fa-spin'></i>">Search</button>
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
        function printAbsentPageArea(prinAbsenttableArea) {

            var printContents = document.getElementById("prinAbsenttableArea").innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            window.close();
            document.body.innerHTML = originalContents;
        }

    </script>
@endsection
