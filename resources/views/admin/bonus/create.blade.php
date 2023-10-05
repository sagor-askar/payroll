@extends('layouts.admin')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 style="color: #605CA8;"><b>Bonus Evaluation</b></h4>
                    </div>
                    <div class="panel-body">
                        <form method="POST" action="{{ route("admin.bonus.search") }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-6 col-sm-3">
                                        <div class="form-group {{ $errors->has('sub_company_id') ? 'has-error' : '' }}">
                                            <label class="" for="sub_company_id">Sub Company</label>
                                            <select class="form-control select3" name="sub_company_id"  id="sub_company_id" >
                                                <option value="">Select One</option>
                                                @foreach($sub_companies as $id => $sub_company)
                                                    <option value="{{ $sub_company->id }}">{{ $sub_company->sub_company_name }}</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('sub_company_id'))
                                                <span class="help-block" role="alert">{{ $errors->first('sub_company_id') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group {{ $errors->has('department') ? 'has-error' : '' }}">
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
                                    </div>

                                    <div class="col-md-6">
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

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="required"  for="ot_date">Date</label>
                                            <input class="form-control date" placeholder="Pick Your Date" type="text" name="date" id="date" value="" required>
                                            <span class="help-block" role="alert">{{ $errors->first('from_holiday') }}</span>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group {{ $errors->has('bonus_name') ? 'has-error' : '' }}">
                                            <label class="required" for="bonus_name">Bonus Name</label>
                                            <input class="form-control" type="text" name="bonus_name" id="bonus_name" value="" placeholder="Bonus Name" required>
                                            @if($errors->has('bonus_name'))
                                                <span class="help-block" role="alert"></span>
                                            @endif
                                            <span class="help-block"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group {{ $errors->has('percentage') ? 'has-error' : '' }}">
                                            <label class="required" for="percentage">Percentage</label>
                                            <input class="form-control" type="text" name="percentage" id="percentage" value="" placeholder="Percentage" required>
                                            @if($errors->has('percentage'))
                                                <span class="help-block" role="alert"></span>
                                            @endif
                                            <span class="help-block"></span>
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

                <!-- functionalities after search -->


                <!-- table contains data -->
                @if(count($employeeData) > 0)
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 style="color: #605CA8;"><b>Bonus Calculation</b></h4>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <form method="POST" action="{{ route("admin.bonus.store") }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table table-striped">
                                                <thead style="background-color: #605CA8; color: white;">
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">ID</th>
                                                    <th scope="col">Employee</th>
                                                    <th scope="col">Amount</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($employeeData as $key=> $employee)
                                                    @php
                                                        $salaryAllowance = \App\Models\SalaryAllowance::where('allowance_name','like','%'.'basic'.'%')->first();
                                                        $basicSalaryInfo = \App\Models\EmployeeSalary::where('employee_id',$employee->id)->where('salary_allowance_id',$salaryAllowance->id)->first();
                                                        $amount =  ($basicSalaryInfo->salary * $percentage)/100;
                                                    @endphp
                                                    <tr>
                                                        <th scope="row">{{$key+1}}</th>
                                                        <td>{{$employee->employee_manual_id}}</td>
                                                        <td>{{$employee->first_name.' '.$employee->last_name}}</td>
                                                        <td>
                                                            <input  type="hidden" name="employee_id[]" value="{{$employee->id}}">
                                                            <input  type="hidden" name="bonus_name[]" value="{{$bonus_name}}">
                                                            <input  type="hidden" name="bonus_percentage[]" value="{{$percentage}}">
                                                            <input  type="hidden" name="bonus_date[]" value="{{$bonus_date}}">
                                                            <input class="form-control" type="text" name="amount[]" value="{{$amount}}">
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <button class="button" type="submit">
                                            Save
                                        </button>
                                    </div>
                                </form>
                            </div>
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
            $('.bonusApply').on('click', function () {
                console.log('ok');
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
@endsection
