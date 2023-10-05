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
                    <h4 style="color: #605CA8;"><b>Monthly Absents</b></h4>
                </div>

                <div class="panel-body">
                    <form id="basic-form" method="POST" action="{{ route("admin.monthly.absents_attendances.report") }}" enctype="multipart/form-data">
                        @csrf

                        <div class="col-md-6 col-ms-3">
                            <div class="form-group {{ $errors->has('department') ? 'has-error' : '' }}">
                                <label for="department_id">{{ trans('cruds.employee.fields.department') }}</label>
                                <select class="form-control select3" id="department_id">
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

                            <div class="form-group {{ $errors->has('employee') ? 'has-error' : '' }}">
                                <label class="required" for="employee_id">{{ trans('cruds.attendance.fields.employee') }}</label>
                                <select class="form-control select2" name="employee_id" id="employee_id" required>
                                    <option value="">Select employee</option>
                                    @foreach($employees as $id => $entry)
                                        <option value="{{ $entry->id }}">{{ $entry->first_name }}({{ $entry->employee_manual_id }})</option>
                                    @endforeach
                                </select>
                                @if($errors->has('employee'))
                                    <span class="help-block" role="alert">{{ $errors->first('employee') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.attendance.fields.employee_helper') }}</span>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-3">
                            <div class="form-group">
                                <label class="required" for="date">Year</label>
                                <select class="form-control" name="year" id="ddlYears">
                                </select>
                                <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js">
                                </script>
                                <script type="text/javascript">
                                    $(function() {
                                        var ddlYears = $("#ddlYears");

                                        var currentYear = (new Date()).getFullYear();

                                        for (var i = currentYear; i >= 1990; i--) {
                                            var option = $("<option />");
                                            option.html(i);
                                            option.val(i);
                                            ddlYears.append(option);
                                        }
                                    });
                                </script>
                            </div>

                            <div class="form-group">
                                <label class="required" for="date">Month</label>
                                <select class="form-control" name="month" id="month">
                                    <option value="01">January</option>
                                    <option value="02">February</option>
                                    <option value="03">March</option>
                                    <option value="04">April</option>
                                    <option value="05">May</option>
                                    <option value="06">June</option>
                                    <option value="07">July</option>
                                    <option value="08">August</option>
                                    <option value="09">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12 col-ms-3">
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
                            $('#employee_id').empty();
                            $('#employee_id').focus;
                            $('#employee_id').append('<option value="0" required="" >Select One </option>');
                            $.each(data, function(key, value){
                                $('select[name="employee_id"]').append('<option value="'+ value.id +'">' + value.first_name+' '+ value.last_name + '</option>');
                            });
                        }else{
                            $('#employee_id').empty();
                        }
                    },
                    error: function () {

                    }
                });
            });
        });
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

