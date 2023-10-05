@extends('layouts.admin')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 style="color: #605CA8;"><b>Increment Evaluation</b></h4>
                    </div>
                    <div class="panel-body">
                        <form method="POST" action="{{ route("admin.increment.store") }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group col-md-4 {{ $errors->has('sub_company_id') ? 'has-error' : '' }}">
                                        <label class="" for="sub_company_id">Sub Company</label>
                                        <select class="form-control select3" name="sub_company_id"  id="sub_com_id" >
                                            <option value="">Select One</option>
                                            @foreach($sub_companies as $id => $sub_company)
                                                <option value="{{ $sub_company->id }}">{{ $sub_company->sub_company_name }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('sub_company_id'))
                                            <span class="help-block" role="alert">{{ $errors->first('sub_company_id') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group col-md-4 {{ $errors->has('department') ? 'has-error' : '' }}">
                                        <label  for="department_id">{{ trans('cruds.employee.fields.department') }}</label>
                                        <select class="form-control select2" name="department_id" id="department_id" >
                                            <option value="">Select Department</option>
                                            @foreach($departments as $id => $entry)
                                                <option value="{{ $entry->id }}" {{ old('department_id') == $entry->id ? 'selected' : '' }}>{{ $entry->department_name }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('employee'))
                                            <span class="help-block" role="alert">{{ $errors->first('employee') }}</span>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.attendance.fields.employee_helper') }}</span>
                                    </div>
                                    <div class="form-group col-md-4 {{ $errors->has('employee') ? 'has-error' : '' }}">
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
                                <div class="col-md-12">
                                    <div class="form-group col-md-4">
                                        <div class="form-group {{ $errors->has('gross_salary') ? 'has-error' : '' }}">
                                            <label for="gross_salary">Gross Salary</label>
                                            <input readonly class="form-control" type="text" name="gross_salary" id="gross_salary" value="" placeholder="Gross Salary">
                                            @if($errors->has('gross_salary'))
                                                <span class="help-block" role="alert"></span>
                                            @endif
                                            <span class="help-block"></span>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <div class="form-group {{ $errors->has('increment_salary') ? 'has-error' : '' }}">
                                            <label class="required" for="increment_salary">Increment Salary</label>
                                            <input class="form-control" type="number" name="increment_salary" id="increment_salary" value="" placeholder="Increment Salary" required>
                                            @if($errors->has('increment_salary'))
                                                <span class="help-block" role="alert"></span>
                                            @endif
                                            <span class="help-block"></span>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <div class="form-group">
                                            <label class="required" for="ot_date">Date</label>
                                            <input class="form-control date" placeholder="Pick Your Date" type="text" name="date" id="date" value="" required>
                                            <span class="help-block" role="alert">{{ $errors->first('from_holiday') }}</span>
                                            <span class="help-block">{{ trans('cruds.holiday.fields.from_holiday_helper') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-md-6">
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
                    url: '{{ route("admin.get_increment_employee.employee") }}',
                    data: {'id': id},
                    dataType: "json",
                    success: function (data) {
                        if(data){
                            $('#employee_id').empty();
                            $('#employee_id').focus;
                            $('#employee_id').append('<option value="0" required="" >Select One </option>');
                            $.each(data, function(key, value){
                                $('select[name="employee_id"]').append('<option value="'+ value.id +'">' + value.first_name+' '+ value.last_name +' '+value.employee_manual_id+'</option>');
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
        $(document).ready(function () {
            $(document).on('change', '#employee_id', function () {
                var id = $(this).val();
                $.ajax({
                    type: 'get',
                    url: '{{ route("admin.get_employee.gross_salary") }}',
                    data: {'id': id},
                    dataType: "json",
                    success: function (data) {
                        if(data){
                            $('#gross_salary').empty();
                            $('#gross_salary').val(data.salary);
                        }else{
                            $('#gross_salary').empty();
                        }
                    },
                    error: function () {

                    }
                });
            });
        });
    </script>

@endsection

