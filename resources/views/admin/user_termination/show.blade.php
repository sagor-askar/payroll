@extends('layouts.admin')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.show') }} {{ trans('cruds.employee.title') }}
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.terminations.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <div>
                            <h3 style=" border:10px;">General Information</h3>
                            <hr>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-bordered table-striped">
                                    <tbody>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.employee.fields.employee_manual_id') }}
                                        </th>
                                        <td>
                                            {{ $employee->employee_manual_id }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.employee.fields.first_name') }}
                                        </th>
                                        <td>
                                            {{ $employee->first_name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.employee.fields.last_name') }}
                                        </th>
                                        <td>
                                            {{ $employee->last_name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.employee.fields.father_name') }}
                                        </th>
                                        <td>
                                            {{ $employee->father_name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.employee.fields.mother_name') }}
                                        </th>
                                        <td>
                                            {{ $employee->mother_name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.employee.fields.address') }}
                                        </th>
                                        <td>
                                            {{ $employee->address }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.employee.fields.email') }}
                                        </th>
                                        <td>
                                            {{ $employee->email }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.employee.fields.contact_no') }}
                                        </th>
                                        <td>
                                            {{ $employee->contact_no }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.employee.fields.gender') }}
                                        </th>
                                        <td>
                                            {{ App\Models\Employee::GENDER_SELECT[$employee->gender] ?? '' }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>
                                            {{ trans('cruds.employee.fields.blood_group') }}
                                        </th>
                                        <td>
                                            {{ $employee->blood_group }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.employee.fields.department') }}
                                        </th>
                                        <td>
                                            {{ $employee->department->department_name ?? '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.employee.fields.designation') }}
                                        </th>
                                        <td>
                                            {{ $employee->designation->designation_name ?? '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.employee.fields.grade') }}
                                        </th>
                                        <td>
                                            {{ $employee->grade->grade ?? '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.employee.fields.attendance_type') }}
                                        </th>

                                        @if($employee->attendance_type == "Branch")
                                            <td><strong style="color: #dd4b39"> Branch</strong> </td>
                                        @elseif($employee->attendance_type == "Roster")
                                            <td><strong style="color: darkgreen"> Roster</strong> </td>
                                        @else
                                            <td><strong style="color: red"> Shift</strong> </td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <th>
                                            Status
                                        </th>
                                            <td><strong style="color: #dd4b39"> Deboarding</strong> </td>                                      
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-bordered table-striped">
                                    <tbody>

                                    <tr>
                                        <th>
                                            {{ trans('cruds.employee.fields.spouse') }}
                                        </th>
                                        @if($employee->spouse == NULL)
                                            <td style="color: red">Not Married Yet.</td>
                                        @else
                                            <td>{{ $employee->spouse }}</td>
                                        @endif
                                    </tr>

                                    <tr>
                                        <th>
                                            {{ trans('cruds.employee.fields.spouse_contact_no') }}
                                        </th>
                                        @if($employee->spouse_contact_no == NULL)
                                            <td style="color: red">Not Married Yet.</td>
                                        @else
                                            <td>
                                                {{ $employee->spouse_contact_no }}
                                            </td>
                                        @endif
                                    </tr>

                                    <tr>
                                        <th>
                                            {{ trans('cruds.employee.fields.emergency_contact_no') }}
                                        </th>
                                        @if($employee->emergency_contact_no == NULL)
                                            <td style="color: red">Not Married Yet.</td>
                                        @else
                                        <td>
                                            {{ $employee->emergency_contact_no }}
                                        </td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.employee.fields.account_holder_name') }}
                                        </th>
                                        <td>
                                            {{ $employee->account_holder_name }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>
                                            {{ trans('cruds.employee.fields.account_number') }}
                                        </th>
                                        <td>
                                            {{ $employee->account_number }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>
                                            {{ trans('cruds.employee.fields.bank_name') }}
                                        </th>
                                        <td>
                                            {{ $employee->bank_name }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>
                                            {{ trans('cruds.employee.fields.branch_name') }}
                                        </th>
                                        <td>
                                            {{ $employee->branch_name }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>
                                            {{ trans('cruds.employee.fields.joining_date') }}
                                        </th>
                                        <td>
                                            {{ $employee->joining_date }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.employee.fields.certificates') }}
                                        </th>
                                        <td>
                                            @foreach($employee->certificates as $key => $media)
                                                <a href="{{ $media->getUrl() }}" target="_blank">
                                                    {{ trans('global.view_file') }}
                                                </a>
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.employee.fields.noc') }}
                                        </th>
                                        <td>
                                            @if($employee->noc)
                                                <a href="{{ $employee->noc->getUrl() }}" target="_blank">
                                                    {{ trans('global.view_file') }}
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.employee.fields.resume') }}
                                        </th>
                                        <td>
                                            @if($employee->resume)
                                                <a href="{{ $employee->resume->getUrl() }}" target="_blank">
                                                    {{ trans('global.view_file') }}
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.employee.fields.photo') }}
                                        </th>
                                        <td>
                                            @if($employee->photo)
                                                <a href="{{ $employee->photo->getUrl() }}" target="_blank" style="display: inline-block">
                                                    <img src="{{ $employee->photo->getUrl('thumb') }}">
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <div>
                                        <h3 style="border:10px;">Salary Information</h3>
                                        <hr>
                                    </div>
                                    <div>
                                        <table class="table table-bordered table-striped">
                                            <thead style="background-color: #605CA8; color: white;">
                                                <tr>
                                                    <th scope="col">SL</th>
                                                    <th scope="col">Allowance Name</th>
                                                    <th scope="col">Percentage</th>
                                                    <th scope="col">Salary</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($employee_salaries as $key=> $salaryinfo)
                                                <tr>
                                                    <th scope="row">{{ $key+1}}</th>
                                                    <td>{{ $salaryinfo->salary_allowance->allowance_name}}</td>
                                                    <td>{{ $salaryinfo->salary_allowance->percentage}} % </td>
                                                    <td>{{ $salaryinfo->salary}}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <div>
                                        <h3 style=" border:10px;">Educational Information</h3>
                                        <hr>
                                    </div>
                                    <div>
                                        <table class="table table-bordered table-striped">
                                            <thead style="background-color: #605CA8; color: white;">
                                            <tr>
                                                <th scope="col">SL</th>
                                                <th scope="col">Examination</th>
                                                <th scope="col">Institute</th>
                                                <th scope="col">Passing Year</th>
                                                <th scope="col"> Result</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($education as $key=> $info)
                                                <tr>
                                                    <th scope="row">{{ $key+1}}</th>
                                                    <td>{{ $info->examination}}</td>
                                                    <td>{{ $info->institue}}</td>
                                                    <td>{{ $info->passing_year}}</td>
                                                    <td>{{ $info->result}}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.terminations.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
