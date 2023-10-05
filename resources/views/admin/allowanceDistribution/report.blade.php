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
                    <h4 style="color: #605CA8;"><b>Additional Allowance Report</b></h4>
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route("admin.allowance-distribution.search") }}" enctype="multipart/form-data">
                        @csrf
                        <!-- additional allowance distribution report  -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group {{ $errors->has('department') ? 'has-error' : '' }}">
                                    <label  for="department_id">{{ trans('cruds.employee.fields.department') }}</label>
                                    <select class="form-control select3" name="department_id" id="department_id">
                                        <option value="">Select Department</option>
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
                            <div class="col-md-4">
                                <div class="form-group {{ $errors->has('employee') ? 'has-error' : '' }}">
                                    <label  for="employee_id">{{ trans('cruds.attendance.fields.employee') }}</label>
                                    <select class="form-control select2" name="employee_id" id="employee_id" >
                                        <option value="">Select Employee</option>
                                        @foreach($employees as $id => $entry)
                                            <option value="{{ $entry->id }}" {{ old('employee_id') == $entry->id ? 'selected' : '' }}>{{ $entry->first_name }}( {{ $entry->employee_manual_id }} )</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('employee'))
                                        <span class="help-block" role="alert">{{ $errors->first('employee') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.attendance.fields.employee_helper') }}</span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group {{ $errors->has('additional_allowance_setup_id') ? 'has-error' : '' }}">
                                    <label for="allowance_name">Allowance Type</label>
                                    <select class="form-control select2" name="additional_allowance_setup_id" id="additional_allowance_setup_id">
                                    <option value="">Select Allowance Name</option>
                                        @foreach($allowance as $id => $entry)
                                            <option value="{{ $id }}" {{ old('additional_allowance_setup_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('additional_allowance_setup_id'))
                                        <span class="help-block" role="alert">{{ $errors->first('additional_allowance_setup_id') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.leaveApplication.fields.employee_helper') }}</span>
                                </div>
                        </div>



                        <div class="col-md-4">
                            <div class="form-group {{ $errors->has('start_date') ? 'has-error' : '' }}">
                                <label  for="start_date">From</label>
                                <input placeholder="Pick your date" class="form-control date" type="text" name="start_date" id="start_date" value="{{ old('start_date') }}">
                                @if($errors->has('start_date'))
                                    <span class="help-block" role="alert">{{ $errors->first('start_date') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.attendance.fields.date_helper') }}</span>
                            </div>
                        </div>

                            <div class="col-md-4">
                                <div class="form-group {{ $errors->has('end_date') ? 'has-error' : '' }}">
                                    <label  for="end_date">To</label>
                                    <input placeholder="Pick your date" class="form-control date" type="text" name="end_date" id="end_date" value="{{ old('end_date') }}">
                                    @if($errors->has('end_date'))
                                        <span class="help-block" role="alert">{{ $errors->first('end_date') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.attendance.fields.date_helper') }}</span>
                                </div>
                            </div>


                        </div>

                        <div class="col-md-12">
                            <div class="form-group" style="margin-left: -14px;">
                                <button class="button" type="submit">
                                    Search
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

            <!-- lower form design -->
            @if(count($additional_allowance_distribution) > 0 )
            <div class="panel panel-default">
                <div class="panel-heading" style="padding: 2px;">
                        <h4 style="color: #605CA8;">Allowance Reports</h4>
                        <button  style="float: right;margin-top: -40px;" type="button" class="btn btn-warning text-right" id="btnPrint" onclick="printPageArea('printableArea');">
                            <i class="fa fa-print"></i>
                        </button>
                </div>
                <div class="table-responsive" id="printableArea">
                    <br>
                    <div class="heading">
                        <table width="99%" style="margin-top: -50px;" >
                            <tbody>
                            <tr>
                                <td width="30%" align="left"  >
                                    <img  src="{{url('images/settings/',$setting->company_logo)}}"  alt="logo" style="margin-top: 25px ;max-width:80px;height: 80px; ">
                                </td>
                                <td width="40%" align="center" >
                                    <h3 style="padding-top: 20px;">{{ $setting->company_title }}</h3>
                                    <h6>{{ $setting->company_email }}</h6>
                                    <h6>{{ $setting->company_phone }}</h6>
                                    <h6>{{ $setting->company_address }}</h6>
                                </td>
                                <td width="30%" align="right">

                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="row mb-5">
                            <table width="99%">
                                <thead>
                                <tr style="height:40px; background-color: #E7E0EE;">
                                    <th class="text-center fs-20"> Additional allowance reports</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <br>
                    <table class="table table-sm table-bordered table-striped table-hover">
                        <thead style="background-color: #605CA8; color: white;">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Employee</th>
                                <th scope="col">Allowance Name</th>
                                <th scope="col">Date</th>
                                <th scope="col">Allowance Amount</th>
                            </tr>
                        </thead>
                        <tbody>

                        @php
                        $total_allownce_amount = 0;
                        @endphp

                        @foreach($additional_allowance_distribution as $key=>$value)
                            @php
                                $total_allownce_amount += $value->allowance;
                            @endphp
                            <tr>
                                <th scope="row">{{$key+1}}</th>
                                <td>{{$value->employee->first_name.' '.$value->employee->last_name}} ({{$value->employee->employee_manual_id}})</td>
                                <td>{{$value->additional_allowance_setup->allowance_name}}</td>
                                <td>{{$value->allowance_date}}</td>
                                <td>{{$value->allowance}} BDT</td>
                            </tr>
                        @endforeach
                                <tr>
                                    <th scope="row"></th>
                                    <td></td>
                                    <td></td>
                                    <td colspan="1"><b>Total: </b></td>
                                    <td colspan="">{{$total_allownce_amount}} BDT</td>
                                </tr>
                        </tbody>
                    </table>
                </div>
            </div>         

           
            @endif

        </div>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        $(document).on('change', '#sub_com_id', function () {
            var id = $(this).val();
            $.ajax({
                type: 'get',
                url: '{{ route("admin.get_employee.department") }}',
                data: {'id': id},
                dataType: "json",
                success: function (data) {
                    if(data){
                        $('#department_id').empty();
                        $('#department_id').focus;
                        $('#department_id').append('<option value="0" required="" >Select Department </option>');
                        $.each(data, function(key, value){
                            $('select[name="department_id"]').append('<option value="'+ value.id +'">' + value.department_name+ '</option>');
                        });
                    }else{
                        $('#department_id').empty();
                    }
                },
                error: function () {

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
                            $('select[name="employee_id"]').append('<option value="'+ value.id +'">' + value.first_name+' '+ value.last_name + '('+ value.employee_manual_id +')' +'</option>');
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


