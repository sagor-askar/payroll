@extends('layouts.admin')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.show') }} Salary Advance
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.salary-advance.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>

                        @if($role_title == 'HR' || $role_title == 'Admin')
                            <div class="form-group" style="float: right">
                                @if($salaryAdvance->status == 1)
                                    <a  class="btn btn-xs btn-primary disabled" onclick="return approveFunction();" href="{{ route('admin.salary-advance.approve', $salaryAdvance->id) }}">
                                        <i class="fa fa-check-circle" style="font-size:25px;color:limegreen" aria-hidden="true">Approved</i>
                                    </a>

                                    <a  class="btn btn-xs btn-danger" onclick="return cancelFunction();" style="display: inline-block;"href="{{ route('admin.salary-advance.cancel', $salaryAdvance->id) }}">
                                        <i class="fa fa-times" style="font-size:25px;" aria-hidden="true">Cancel</i>
                                    </a>
                                @else
                                    <a  class="btn btn-xs btn-primary" onclick="return approveFunction();" href="{{ route('admin.salary-advance.approve', $salaryAdvance->id) }}">
                                        <i class="fa fa-check-circle" style="font-size:25px;color:limegreen" aria-hidden="true">Approve</i>
                                    </a>
                                @endif
                                @if($salaryAdvance->status == 0)
                                    <a class="btn btn-xs btn-warning" onclick="return rejectFunction();" href="{{ route('admin.salary-advance.reject', $salaryAdvance->id) }}">
                                        <i class="fa fa-times-circle" style="font-size:25px;color:red" aria-hidden="true">Reject</i>
                                    </a>
                                @endif
                            </div>
                        @endif
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                       Employee Id
                                    </th>
                                    <td>
                                        {{ $salaryAdvance->employee->employee_manual_id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.leaveApplication.fields.employee') }}
                                    </th>
                                    <td>
                                        {{ $salaryAdvance->employee->first_name .' '.$salaryAdvance->employee->last_name }}
                                    </td>
                                </tr>

                                
                                <tr>
                                    <th>
                                        {{ trans('cruds.leaveApplication.fields.company') }}
                                    </th>
                                    <td>
                                        {{ $salaryAdvance->employee->company->comp_name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                       Sub Company
                                    </th>
                                    <td>
                                        {{ $salaryAdvance->employee->subcompany->sub_company_name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.leaveApplication.fields.department') }}
                                    </th>
                                    <td>
                                        {{ $salaryAdvance->employee->department->department_name ?? '' }}
                                    </td>
                                </tr>
                               
                                <tr>
                                    <th>
                                       Advance Amount
                                    </th>
                                    <td>
                                        {{ $salaryAdvance->amount}} BDT
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Date
                                    </th>
                                    <td>
                                        {{  \Carbon\Carbon::parse($salaryAdvance->sd_date)->format('d-m-Y')}}
                                    </td>
                                </tr>

                                <tr>
                                    <th>
                                        Reason
                                    </th>
                                    <td>
                                        {{ $salaryAdvance->reason}}
                                    </td>
                                </tr>

                                <tr>
                                    <th>
                                        Created By
                                    </th>
                                    <td>
                                        {{ $salaryAdvance->user->name}}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                       Paid Status
                                    </th>

                                    @if($salaryAdvance->paid_status == 0)
                                        <td><strong style="color: #dd4b39"> Unpaid</strong> </td>
                                    @else
                                        <td><strong style="color: darkgreen"> Paid</strong> </td>
                                    @endif
                                </tr>

                                <tr>
                                    <th>
                                        Approved  Status
                                    </th>
                                    @if($salaryAdvance->status == 0)
                                        <td><strong style="color: #dd4b39"> Pending</strong> </td>
                                    @elseif($salaryAdvance->status == 1)
                                        <td><strong style="color: darkgreen"> Approved</strong> </td>
                                    @else
                                        <td><strong style="color: red"> Rejected</strong> </td>
                                    @endif
                                </tr>

                            </tbody>
                        </table>

                    <div >
                        <h4 style="text-align: center"> <strong>Advance History</strong></h4>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class=" table table-bordered table-striped table-hover datatable datatable-LeaveApplication">
                                    <thead>
                                    <tr>
                                        <th width="10">

                                        </th>
                                        <th>
                                            {{ trans('cruds.leaveApplication.fields.employee') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.leaveApplication.fields.department') }}
                                        </th>

                                        <th>
                                            Advance Amount
                                        </th>
                                        <th>
                                           Date
                                        </th>
                                        <th>
                                           Created By
                                        </th>
                                        <th>
                                            Paid Status
                                        </th>
                                        <th>
                                            Unpaid Status
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($salaryAdvanceHistory as $key => $salaryHistory)
                                        <tr data-entry-id="{{ $salaryHistory->id }}">
                                            <td>

                                            </td>
                                            <td>
                                                {{ $salaryHistory->employee->first_name.' '.$salaryHistory->employee->last_name }}
                                            </td>
                                            <td>
                                                {{ $salaryHistory->employee->department->department_name ?? '' }}
                                            </td>
                                            <td>
                                                {{ $salaryHistory->amount}}
                                            </td>
                                            <td>
                                                {{ $salaryHistory->sd_date }}
                                            </td>
                                            <td>
                                                {{ $salaryHistory->user->name  }}
                                            </td>
                                            @if($salaryHistory->paid_status == 0)
                                                <td><strong style="color: #dd4b39"> Unpaid</strong> </td>
                                            @else
                                                <td><strong style="color: darkgreen"> Paid</strong> </td>
                                            @endif

                                            @if($salaryHistory->status == 0)
                                                <td><strong style="color: #dd4b39"> Pending</strong> </td>
                                            @elseif($salaryHistory->status == 1)
                                                <td><strong style="color: darkgreen"> Approved</strong> </td>
                                            @else
                                                <td><strong style="color: red"> Rejected</strong> </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.salary-advance.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>
</div>

<script>
    function rejectFunction() {
        if(!confirm("Are You Sure to Reject ?"))
            event.preventDefault();
    }
</script>

<script>
    function approveFunction() {
        if(!confirm("You are going to Approve !"))
            event.preventDefault();
    }
</script>

<script>
    function cancelFunction() {
    if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
            headers: {'x-csrf-token': _token},
            method: 'POST',
            url: config.url,
            data: { ids: ids, _method: 'DELETE' }})
            .done(function () { location.reload() })
    }
    }
</script>
@endsection
