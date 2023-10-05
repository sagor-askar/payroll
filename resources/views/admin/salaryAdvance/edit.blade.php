@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                  Update Salary Advance
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route("admin.salary-advance.update", [$salaryAdvance->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                @if( $role_title  == 'Employee')
                                <div class="form-group {{ $errors->has('employee') ? 'has-error' : '' }}">
                                    <label class="required" for="employee_id">{{ trans('cruds.leaveApplication.fields.employee') }}</label>
                                    <select class="form-control select2" name="employee_id" id="employee_id" required>
                                        @foreach($user_employees as $id => $entry)
                                            <option selected value="{{ $entry->id }}" {{ (old('employee_id') ? old('employee_id') : $salaryAdvance->employee->id ?? '') == $entry->id ? 'selected' : '' }}>{{ $entry->first_name }} ({{ $entry->employee_manual_id }})</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('employee'))
                                        <span class="help-block" role="alert">{{ $errors->first('employee') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.leaveApplication.fields.employee_helper') }}</span>
                                </div>

                                    <div class="form-group {{ $errors->has('amount') ? 'has-error' : '' }}">
                                        <label class="required" for="end_date">Amount</label>
                                        <input class="form-control" type="number" name="amount" id="amount" value="{{ old('amount',$salaryAdvance->amount) }}" required>
                                        @if($errors->has('amount'))
                                            <span class="help-block" role="alert">{{ $errors->first('amount') }}</span>
                                        @endif
                                        <span class="help-block"></span>
                                    </div>
                                @else

                                    <div class="form-group {{ $errors->has('company') ? 'has-error' : '' }}">
                                        <label class="required" for="company_id">{{ trans('cruds.leaveApplication.fields.company') }}</label>
                                        <select class="form-control select2" name="company_id" id="company_id" required>
                                            @foreach($companies as $id => $entry)
                                                <option value="{{ $id }}" {{ (old('company_id') ? old('company_id') : $salaryAdvance->company->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('company'))
                                            <span class="help-block" role="alert">{{ $errors->first('company') }}</span>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.leaveApplication.fields.company_helper') }}</span>
                                    </div>
                                    <div class="form-group {{ $errors->has('sub_company_id') ? 'has-error' : '' }}">
                                        <label class="required" for="sub_company_id">{{ trans('cruds.leaveApplication.fields.sub_company_id') }}</label>
                                        <select class="form-control select2" name="sub_company_id" id="sub_com_id" required>
                                            @foreach($sub_companies as $id => $entry)
                                                <option value="{{ $id }}" {{ (old('sub_company_id') ? old('sub_company_id') : $salaryAdvance->subcompany->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('sub_company_id'))
                                            <span class="help-block" role="alert">{{ $errors->first('sub_company_id') }}</span>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.leaveApplication.fields.sub_company_id_helper') }}</span>
                                    </div>
                                    <div class="form-group {{ $errors->has('employee') ? 'has-error' : '' }}">
                                        <label class="required" for="employee_id">{{ trans('cruds.leaveApplication.fields.employee') }}</label>
                                        <select class="form-control select2" name="employee_id" id="employee_id" required>
                                            @foreach($user_employees as $id => $entry)
                                                <option value="{{ $entry->id }}" {{ (old('employee_id') ? old('employee_id') : $salaryAdvance->employee->id ?? '') == $entry->id ? 'selected' : '' }}>{{ $entry->first_name }} ({{ $entry->employee_manual_id }})</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('employee'))
                                            <span class="help-block" role="alert">{{ $errors->first('employee') }}</span>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.leaveApplication.fields.employee_helper') }}</span>
                                    </div>

                                    <div class="form-group {{ $errors->has('amount') ? 'has-error' : '' }}">
                                        <label class="required" for="end_date">Amount</label>
                                        <input class="form-control" type="number" name="amount" id="amount" value="{{ old('amount',$salaryAdvance->amount) }}" required>
                                        @if($errors->has('amount'))
                                            <span class="help-block" role="alert">{{ $errors->first('amount') }}</span>
                                        @endif
                                        <span class="help-block"></span>
                                    </div>

                                @endif

                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="required" >Date</label>
                                    <input class="form-control date" type="text" name="sd_date" id="sd_date" value="{{ old('sd_date',$salaryAdvance->sd_date) }}" required>
                                </div>

                                    <div class="form-group {{ $errors->has('reason') ? 'has-error' : '' }}">
                                        <label for="reason">{{ trans('cruds.leaveApplication.fields.reason') }}</label>
                                        <textarea class="form-control" name="reason" id="reason" cols="45" rows="5">{!! $salaryAdvance->reason !!}</textarea>
                                        @if($errors->has('reason'))
                                            <span class="help-block" role="alert">{{ $errors->first('reason') }}</span>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.leaveApplication.fields.reason_helper') }}</span>
                                    </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="button" type="submit">
                                {{ trans('global.save') }}
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
                    url: '{{ route("admin.get_employee.sub_company") }}',
                    data: {'id': id},
                    dataType: "json",
                    success: function (data) {
                        if(data){
                            $('#employee_id').empty();
                            $('#employee_id').focus;
                            $('#employee_id').append('<option value="0" required="" >Select Employee </option>');
                            $.each(data, function(key, value){
                                $('select[name="employee_id"]').append('<option value="'+ value.id +'">' + value.first_name+' '+value.last_name+ '</option>');
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
        $(document).on('change', '#department_id', function () {
            var id = $(this).val();
            $.ajax({
                type: 'get',
                url: '{{ route("admin.get_reporting_employee.employee") }}',
                data: {'id': id},
                dataType: "json",
                success: function (data) {
                    if(data){
                        $('#assign_employee_id').empty();
                        $('#assign_employee_id').focus;
                        $('#assign_employee_id').append('<option value="0" required="" >Select One </option>');
                        $.each(data, function(key, value){
                            $('select[name="assign_employee_id"]').append('<option value="'+ value.id +'">' + value.first_name+' '+ value.last_name +'</option>');
                        });
                    }else{
                        $('#assign_employee_id').empty();
                    }
                },
                error: function () {

                }
            });
        });
    });
</script>

@endsection
