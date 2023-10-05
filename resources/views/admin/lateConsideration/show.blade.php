@extends('layouts.admin')
@section('content')
    <div class="content">

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                      Show Late Consideration List
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="form-group">
                                <a class="btn btn-default" href="{{ route('admin.late-consideration.index') }}">
                                    {{ trans('global.back_to_list') }}
                                </a>
{{--                                <a style="float: right" type="button" class="btn btn-primary" href=" {{ route('admin.late-consideration.pdf',$lateConsider->id) }}"><i class="fa fa-print" title="Print From Here"></i></a><hr>--}}
                            </div>
                            @if($role_title == 'HR' || $role_title == 'Admin')
                                <div class="form-group" style="float: right">
                                    @if($lateConsider->status == 1)
                                        <a  class="btn btn-xs btn-primary disabled" onclick="return approveFunction();" href="{{ route('admin.late-consideration.approve', $lateConsider->id) }}">
                                            <i class="fa fa-check-circle" style="font-size:25px;color:limegreen" aria-hidden="true">Approved</i>
                                        </a>

                                        <a  class="btn btn-xs btn-danger" onclick="return cancelFunction();" style="display: inline-block;"href="{{ route('admin.late-consideration.cancel', $lateConsider->id) }}">
                                            <i class="fa fa-times" style="font-size:25px;" aria-hidden="true">Cancel</i>
                                        </a>
                                    @else
                                        <a  class="btn btn-xs btn-primary" onclick="return approveFunction();" href="{{ route('admin.late-consideration.approve', $lateConsider->id) }}">
                                            <i class="fa fa-check-circle" style="font-size:25px;color:limegreen" aria-hidden="true">Approve</i>
                                        </a>
                                    @endif
                                    @if($lateConsider->status == 0)
                                        <a class="btn btn-xs btn-warning" onclick="return rejectFunction();" href="{{ route('admin.late-consideration.reject', $lateConsider->id) }}">
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
                                    {{ $lateConsider->employee->employee_manual_id }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.leaveApplication.fields.employee') }}
                                </th>
                                <td>
                                    {{ $lateConsider->employee->first_name .' '.$lateConsider->employee->last_name }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.leaveApplication.fields.department') }}
                                </th>
                                <td>
                                    {{ $lateConsider->employee->department->department_name ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Approved By
                                </th>
                                <td>
                                    {{ $lateConsider->approved_employee->first_name .' '.$lateConsider->approved_employee->last_name }}
                                </td>
                            </tr>

                            <tr>
                                <th>
                                    Clock In
                                </th>
                                <td>
                                    {{ $lateConsider->clock_in }}
                                </td>
                            </tr>

                            <tr>
                                <th>
                                    Clock Out
                                </th>
                                <td>
                                    {{ $lateConsider->clock_out }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                   Date
                                </th>
                                <td>
                                    {{ $lateConsider->date }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.leaveApplication.fields.reason') }}
                                </th>
                                <td>
                                    {{ $lateConsider->reason }}
                                </td>
                            </tr>




                            <tr>
                                <th>
                                    Status
                                </th>
                                @if($lateConsider->status == 0)
                                    <td><strong style="color: #dd4b39"> Pending</strong> </td>
                                @elseif($lateConsider->status == 1)
                                    <td><strong style="color: darkgreen"> Approved</strong> </td>
                                @else
                                    <td><strong style="color: red"> Rejected</strong> </td>
                                @endif
                            </tr>
                            </tbody>
                        </table>

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
