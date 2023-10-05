@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.show') }} {{ trans('cruds.leaveApplication.title') }}
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.leave-applications.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                            <a style="float: right" type="button" class="btn btn-primary" href=" {{ route('admin.leave-applications.pdf',$leaveApplication->id) }}"><i class="fa fa-print" title="Print From Here"></i></a><hr>
                        </div>
                            @if($role_title == 'HR' || $role_title == 'Admin')
                            <div class="form-group" style="float: right">
                                @if($leaveApplication->status == 1)
                                <a  class="btn btn-xs btn-primary disabled" onclick="return approveFunction();" href="{{ route('admin.leave-applications.approve', $leaveApplication->id) }}">
                                    <i class="fa fa-check-circle" style="font-size:25px;color:limegreen" aria-hidden="true">Approved</i>
                                </a>

                                <a  class="btn btn-xs btn-danger" onclick="return cancelFunction();" style="display: inline-block;"href="{{ route('admin.leave-applications.cancel', $leaveApplication->id) }}">
                                    <i class="fa fa-times" style="font-size:25px;" aria-hidden="true">Cancel</i>
                                </a>

{{--                                <form action="{{ route('admin.leave-applications.destroy', $leaveApplication->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">--}}
{{--                                    <input type="hidden" name="_method" value="DELETE">--}}
{{--                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
{{--                                    <i class="btn btn-sm fa fa-times" aria-hidden="true"> <input type="submit" class="btn btn-sm btn-danger" value="Cancel"></i>--}}
{{--                                </form>--}}

                                @else
                                    <a  class="btn btn-xs btn-primary" onclick="return approveFunction();" href="{{ route('admin.leave-applications.approve', $leaveApplication->id) }}">
                                        <i class="fa fa-check-circle" style="font-size:25px;color:limegreen" aria-hidden="true">Approve</i>
                                    </a>
                                @endif
                               @if($leaveApplication->status == 0)
                                <a class="btn btn-xs btn-warning" onclick="return rejectFunction();" href="{{ route('admin.leave-applications.reject', $leaveApplication->id) }}">
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
                                        {{ $leaveApplication->employee->employee_manual_id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.leaveApplication.fields.employee') }}
                                    </th>
                                    <td>
                                        {{ $leaveApplication->employee->first_name .' '.$leaveApplication->employee->last_name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.leaveApplication.fields.company') }}
                                    </th>
                                    <td>
                                        {{ $leaveApplication->company->comp_name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.leaveApplication.fields.department') }}
                                    </th>
                                    <td>
                                        {{ $leaveApplication->department->department_name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Assign Employee
                                    </th>
                                    <td>
                                        {{ $leaveApplication->assign_employee->first_name.' '.$leaveApplication->assign_employee->last_name }}
                                    </td>
                                </tr>



                                <tr>
                                    <th>
                                        {{ trans('cruds.leaveApplication.fields.leave_type') }}
                                    </th>
                                    <td>
                                        {{ $leaveApplication->leave_type->leave_name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        No. Of Days
                                    </th>
                                    <td>
                                        {{ $leaveApplication->no_of_days ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.leaveApplication.fields.start_date') }}
                                    </th>
                                    <td>
                                        {{ $leaveApplication->start_date }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.leaveApplication.fields.end_date') }}
                                    </th>
                                    <td>
                                        {{ $leaveApplication->end_date }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.leaveApplication.fields.reason') }}
                                    </th>
                                    <td>
                                        {{ $leaveApplication->reason }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    <div >
                        <h4 style="text-align: center"> <strong>Leave History</strong></h4>
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
                                            {{ trans('cruds.leaveApplication.fields.company') }}
                                        </th>

                                        <th>
                                           Assign Employee
                                        </th>

                                        <th>
                                            {{ trans('cruds.leaveApplication.fields.leave_type') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.leaveApplication.fields.start_date') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.leaveApplication.fields.end_date') }}
                                        </th>
                                        <th>
                                            No. Of Days
                                        </th>
                                        <th>
                                            {{ trans('cruds.leaveApplication.fields.status') }}
                                        </th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($leaveApplication_history as $key => $leaveHistory)
                                        <tr data-entry-id="{{ $leaveHistory->id }}">
                                            <td>

                                            </td>
                                            <td>
                                                {{ $leaveHistory->employee->first_name.' '.$leaveHistory->employee->last_name }}
                                            </td>
                                            <td>
                                                {{ $leaveHistory->department->department_name ?? '' }}
                                            </td>
                                            <td>
                                                {{ $leaveHistory->company->comp_name ?? '' }}
                                            </td>
                                            <td>
                                                {{ $leaveHistory->assign_employee->first_name.' '.$leaveHistory->assign_employee->last_name }}
                                            </td>

                                            <td>
                                                {{ $leaveHistory->leave_type->leave_name ?? '' }}
                                            </td>
                                            <td>
                                                {{ $leaveHistory->start_date ?? '' }}
                                            </td>
                                            <td>
                                                {{ $leaveHistory->end_date ?? '' }}
                                            </td>
                                            <td>
                                                {{ $leaveHistory->no_of_days ?? '' }}
                                            </td>
                                            @if($leaveHistory->status == 0)
                                                <td><strong style="color: #dd4b39"> Pending</strong> </td>
                                            @elseif($leaveHistory->status == 1)
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
                            <a class="btn btn-default" href="{{ route('admin.leave-applications.index') }}">
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
