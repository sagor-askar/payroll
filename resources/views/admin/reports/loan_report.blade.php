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
                    <h4 style="color: #605CA8;"><b>Generate Loan Report</b></h4>
                </div>
                <div class="panel-body">
                    <form id="basic-form"  method="POST" action="{{ route('admin.loan_report.search') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-4">
                            <div class="form-group {{ $errors->has('department') ? 'has-error' : '' }}">
                                <label for="department_id">{{ trans('cruds.leaveApplication.fields.department') }}</label>
                                <select class="form-control select2" id="department_id">
                                    <option value="">Select One</option>
                                    @foreach($departments as $id => $entry)
                                        <option value="{{ $id }}" {{ old('department_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('department'))
                                    <span class="help-block" role="alert">{{ $errors->first('department') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.leaveApplication.fields.department_helper') }}</span>
                            </div>
                        </div>

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
                            <div class="form-group">
                                <label  for="">Date</label>
                                <input class="form-control date" placeholder="Pick Your Date" type="text" name="date" id="date" value="{{ old('date') }}">

                                <span class="help-block" role="alert">{{ $errors->first('from_holiday') }}</span>

                                <span class="help-block">{{ trans('cruds.holiday.fields.from_holiday_helper') }}</span>
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
    $(document).ready(function () {

    $(".loanView").on("click",function(){
        var loan_id = ($(this).closest('tr').find('td #loan_id').val());
         $.ajax({
                    type: 'get',
                    url: '{{ url("/admin/reports/loan/loanHistory/") }}',
                    data: {'id': loan_id},
                    dataType: "json",
                    cache: false,
                    success: function (data) {
                        $('#loanhistoryTable').empty();
                        $.each(data, function(i, item) {
                            $('#loanhistoryTable').append(
                            `<tr>
                                <td> ${item.loan_pay_date}  </td>
                                <td>  ${item.pay_amount}  </td>
                                <td>  ${item.due_amount} </td>
                                </tr>`);
                        });

                    },
                    error: function () {
                    }
                });
    });

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
                            $('select[name="employee_id"]').append('<option value="'+ value.id +'">' + value.first_name+' '+ value.last_name +'('+value.employee_manual_id+')'+'</option>');
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
