@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Overtime Request Details View
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('overtime_request.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        @if($role_title == 'HR' || $role_title == 'Admin')
                            <div class="form-group" style="float: right">
                                @if($ot_info->status == 1)
                                <a  class="btn btn-xs btn-primary disabled" onclick="return approveFunction();" href="{{ route('overtime_request.approve', $ot_info->id) }}">
                                    <i class="fa fa-check-circle" style="font-size:25px;color:limegreen" aria-hidden="true">Approved</i>
                                </a>

                                    <a  class="btn btn-xs btn-danger" onclick="return cancelFunction();" style="display: inline-block;"href="{{ route('overtime_request.cancel', $ot_info->id) }}">
                                        <i class="fa fa-times" style="font-size:25px;" aria-hidden="true">Cancel</i>
                                   </a>

                                @else
                                    <a  class="btn btn-xs btn-primary" onclick="return approveFunction();" href="{{ route('overtime_request.approve', $ot_info->id) }}">
                                        <i class="fa fa-check-circle" style="font-size:25px;color:limegreen" aria-hidden="true">Approve</i>
                                    </a>
                                @endif
                               @if($ot_info->status == 0)
                                <a class="btn btn-xs btn-warning" onclick="return rejectFunction();" href="{{ route('overtime_request.reject', $ot_info->id) }}">
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
                                        ID
                                    </th>
                                    <td>
                                        {{ $ot_info->employee->employee_manual_id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Employee
                                    </th>
                                    <td>
                                        {{ $ot_info->employee->first_name.' '.$ot_info->employee->last_name}}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Date
                                    </th>
                                    <td>
                                        {{ $ot_info->ot_date }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Time Slot 
                                    </th>
                                    <td>
                                        {{ $ot_info->ot_time }} Hours
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                      Working Hours
                                    </th>
                                    @if($ot_info->working_hour)
                                    <td>
                                        {{ $ot_info->working_hour  }} Hours
                                    </td>
                                    @else 

                                    <td></td>
                                    @endif
                                </tr>

                                <tr>
                                    <th>
                                     OT Salary
                                    </th>
                                   
                                    <td>
                                        {{ $ot_info->ot_salary  }} 
                                    </td>
                                   
                                </tr>

                                <tr>
                                    <th>
                                        Reason
                                    </th>
                                    <td>
                                        {{ $ot_info->reason }}
                                    </td>
                                </tr>

                                <tr>
                                    <th>
                                        Created By
                                    </th>
                                    <td>
                                        {{ $ot_info->user->name }}
                                    </td>
                                </tr>

                                <tr>
                                    <th>
                                      Status
                                    </th>
                                    @if($ot_info->status == 0)
                                    <td style="color:coral ">
                                       Pending
                                    </td>
                                    @elseif($ot_info->status == 1)
                                    <td style="color:green">
                                     Approved
                                    </td>
                                    @else
                                    <td style="color:red;">Reject</td>
                                    @endif
                                </tr>
                               
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('overtime_request.index') }}">
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
