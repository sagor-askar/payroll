@extends('layouts.admin')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 style="color: #605CA8;"><b>Search Employee</b></h4>
                    </div>
                    <div class="panel-body">
                        <form method="POST" action="{{ route("admin.promotionEmployee.search") }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group col-md-3 {{ $errors->has('sub_company_id') ? 'has-error' : '' }}">
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

                                    <div class="form-group col-md-3 {{ $errors->has('department') ? 'has-error' : '' }}">
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
                                    <div class="form-group col-md-3 {{ $errors->has('employee') ? 'has-error' : '' }}">
                                        <label  for="employee_id">{{ trans('cruds.attendance.fields.employee') }}</label>
                                        <select class="form-control select2" name="employee_id" id="employee_id" >
                                            <option value="">Select Employee</option>
                                            @foreach($employees as $id => $entry)
                                                <option value="{{ $entry->id }}" {{ old('employee_id') == $entry->id ? 'selected' : '' }}>{{ $entry->first_name }} {{ $entry->last_name }} ( {{ $entry->employee_manual_id }} )</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('employee'))
                                            <span class="help-block" role="alert">{{ $errors->first('employee') }}</span>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.attendance.fields.employee_helper') }}</span>
                                    </div>
                                    <div class="form-group col-md-3" style="margin-top: 23px;">
                                        <button class="button" type="submit">
                                            Search
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    @if($promotionHistory != null)
                    <div class="panel-heading">
                        <h4 style="color: #605CA8;">Add Promotion for  - <b> {{$promotionHistory->first_name.' '.$promotionHistory->last_name}} ( {{$promotionHistory->employee_manual_id}} )</b></h4>
                    </div>
                    <div class="panel-body">
                        <form method="POST" action="{{ route("admin.promotion.store") }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group  {{ $errors->has('department') ? 'has-error' : '' }}">
                                        <label  for="department_id">{{ trans('cruds.employee.fields.department') }}</label>
                                        <input type="hidden" name="employee_id" value="{{$promotionHistory->id}}">
                                        <select class="form-control select2" name="department_id" id="department_id" >
                                            <option value="">Select Department</option>
                                            @foreach($departments as $id => $entry)
                                            <option value="{{ $entry->id }}" {{ (old('department_id') ? old('department_id') : $promotionHistory->department->id ?? '') == $entry->id ? 'selected' : '' }}>{{ $entry->department_name }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('employee'))
                                            <span class="help-block" role="alert">{{ $errors->first('employee') }}</span>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.attendance.fields.employee_helper') }}</span>
                                    </div>

                                    <div class="form-group">
                                        <label >Salary</label>
                                        <input readonly class="form-control" type="text" name="previous_amount" value="{{$promotionHistory->salary}}">
                                        @if($errors->has('previous_amount'))
                                            <span class="help-block" role="alert">{{ $errors->first('previous_amount') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label  for="department_id">Salary Type</label>
                                        <select class="form-control select2" id="salary_type" >
                                            <option>Select Type</option>
                                            <option value="1">Percentage</option>
                                            <option value="2"> Amount</option>

                                        </select>
                                        @if($errors->has('employee'))
                                            <span class="help-block" role="alert">{{ $errors->first('employee') }}</span>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.attendance.fields.employee_helper') }}</span>
                                    </div>

                                    <div class="form-group showPercent" style="display: none;">
                                        <div class="form-group">
                                            <label for="percentage"> Promotion Salary (Percentage % )</label>
                                            <input class="form-control" type="number" name="percentage" id="percentage"  placeholder="Salary Percentage">
                                            @if($errors->has('percentage'))
                                                <span class="help-block" role="alert"></span>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="form-group showAmount" style="display: none;">
                                        <div class="form-group">
                                            <label for="amount">Promotion Salary ( Amount )</label>
                                            <input class="form-control" type="number" name="amount" id="amount"  placeholder="Salary Amount">
                                            @if($errors->has('amount'))
                                                <span class="help-block" role="alert"></span>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group  {{ $errors->has('designation') ? 'has-error' : '' }}">
                                        <label  for="department_id">{{ trans('cruds.employee.fields.designation') }}</label>
                                        <select class="form-control select2" name="designation_id" id="designation_id" >
                                            <option value="">Select Designation</option>
                                            @foreach($designation as $id => $entry)
                                                <option value="{{ $entry->id }}" {{ (old('designation_id') ? old('designation_id'): $promotionHistory->designation->id ) == $entry->id ? 'selected' : '' }}>{{ $entry->designation_name }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('designation'))
                                            <span class="help-block" role="alert">{{ $errors->first('designation') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group {{ $errors->has('grade') ? 'has-error' : '' }}">
                                        <label for="grade_id">{{ trans('cruds.employee.fields.grade') }}</label>
                                        <select class="form-control select3" name="grade_id" id="grade_id">
                                            <option value="">Select Grade</option>
                                            @foreach($grades as $id => $entry)
                                                <option value="{{ $entry->id }}" {{ (old('grade_id') ? old('grade_id') : $promotionHistory->grade->id )== $entry->id ? 'selected' : '' }}>
                                                    {{ $entry->grade }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('grade'))
                                            <span class="help-block" role="alert">{{ $errors->first('grade') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group {{ $errors->has('promotion_date') ? 'has-error' : '' }}">
                                        <label  for="promotion_date">Promotion Date</label>
                                        <input class="form-control date" type="text" name="promotion_date" id="promotion_date" value="{{ old('promotion_date') }}">
                                        @if($errors->has('promotion_date'))
                                            <span class="help-block" role="alert">{{ $errors->first('promotion_date') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-3" style="margin-top: 23px;">
                                <button class="button" type="submit">
                                  Update
                                </button>
                            </div>
                        </form>
                    </div>
                    @endif
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
                                $('select[name="employee_id"]').append('<option value="'+ value.id +'">' + value.first_name+' '+ value.last_name +' ( '+value.employee_manual_id+ ')'+'</option>');
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


    <script type="text/javascript">
        $(document).ready(function () {
            $(document).on('change', '#salary_type', function () {
                var id = $(this).val();
                if (id == 1){
                    $(".showPercent").show();
                    $(".showAmount ").hide();
                }else{
                    $(".showAmount ").show();
                    $(".showPercent").hide();
                }
            });
        });
    </script>
@endsection

