@extends('layouts.admin')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                      Show Loan Application List
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="form-group">
                                <a class="btn btn-default" href="{{ route('admin.loan.index') }}">
                                    {{ trans('global.back_to_list') }}
                                </a>
{{--                                <a style="float: right" type="button" class="btn btn-primary" href=" {{ route('admin.late-consideration.pdf',$lateConsider->id) }}"><i class="fa fa-print" title="Print From Here"></i></a><hr>--}}
                            </div>
                            @if($role_title == 'HR' || $role_title == 'Admin')
                                <div class="form-group" style="float: right">
                                    @if($loanApplication->status == 1)
                                        <a  class="btn btn-xs btn-primary disabled" onclick="return approveFunction();" href="{{ route('admin.loan.approve', $loanApplication->id) }}">
                                            <i class="fa fa-check-circle" style="font-size:25px;color:limegreen" aria-hidden="true">Approved</i>
                                        </a>
                                    @else
                                        <a  class="btn btn-xs btn-primary" onclick="return approveFunction();" href="{{ route('admin.loan.approve', $loanApplication->id) }}">
                                            <i class="fa fa-check-circle" style="font-size:25px;color:limegreen" aria-hidden="true">Approve</i>
                                        </a>
                                    @endif
                                    @if($loanApplication->status == 0)
                                        <a class="btn btn-xs btn-warning" onclick="return rejectFunction();" href="{{ route('admin.loan.reject', $loanApplication->id) }}">
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
                                    {{ $loanApplication->employee->employee_manual_id }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.leaveApplication.fields.employee') }}
                                </th>
                                <td>
                                    {{ $loanApplication->employee->first_name .' '.$loanApplication->employee->last_name }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.leaveApplication.fields.department') }}
                                </th>
                                <td>
                                    {{ $loanApplication->employee->department->department_name ?? '' }}
                                </td>
                            </tr>


                            <tr>
                                <th>
                                   Loan Amount
                                </th>
                                <td>
                                    {{ $loanApplication->amount }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                   Installment Amount
                                </th>
                                <td>
                                    {{ $loanApplication->installment_amount }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Adjustment Date
                                </th>
                                <td>
                                    {{ $loanApplication->adjustment_date }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                   Apply Date
                                </th>
                                <td>
                                    {{ $loanApplication->apply_date }}
                                </td>
                            </tr>

                            <tr>
                                <th>
                                 Loan  Details
                                </th>
                                <td>
                                    {{ $loanApplication->loan_details }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Approved Date
                                </th>
                                <td>
                                    {{ $loanApplication->approved_date }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Approved By
                                </th>

                                    <td>
                                        {{ $loanApplication->permitted_employee->name ?? ' ' }}
                                    </td>

                            </tr>

                            <tr>
                                <th>
                                    Status
                                </th>
                                @if($loanApplication->status == 0)
                                    <td><strong style="color: #dd4b39"> Pending</strong> </td>
                                @elseif($loanApplication->status == 1)
                                    <td><strong style="color: darkgreen"> Approved</strong> </td>
                                @else
                                    <td><strong style="color: red"> Rejected</strong> </td>
                                @endif
                            </tr>
                            </tbody>
                        </table>
                        <h4 style="text-align: center"> <strong>Loan Application History</strong></h4>
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
                                            Loan Amount
                                        </th>
                                        <th>
                                            Installment Amount
                                        </th>
                                        <th>
                                            Adjustment Date
                                        </th>
                                        <th>
                                            Apply Date
                                        </th>
                                        <th>
                                            Approved Date
                                        </th>
                                        <th>
                                          Approved By
                                        </th>
                                        <th>
                                            {{ trans('cruds.leaveApplication.fields.status') }}
                                        </th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($loanApplication_history as $key => $loanHistory)
                                        <tr data-entry-id="{{ $loanHistory->id }}">
                                            <td>

                                            </td>
                                            <td>
                                                {{ $loanHistory->employee->first_name.' '.$loanHistory->employee->last_name }}
                                            </td>
                                            <td>
                                                {{ $loanHistory->employee->department->department_name ?? '' }}
                                            </td>
                                            <td>
                                                {{ $loanHistory->amount ?? '' }}
                                            </td>
                                            <td>
                                                {{ $loanHistory->installment_amount ?? '' }}
                                            </td>
                                            <td>
                                                {{ $loanHistory->adjustment_date ?? '' }}
                                            </td>
                                            <td>
                                                {{ $loanHistory->apply_date ?? '' }}
                                            </td>
                                            <td>
                                                {{ $loanHistory->approved_date ?? '' }}
                                            </td>
                                            <td>
                                                {{ $loanHistory->permitted_employee->name ?? ' ' }}
                                            </td>
                                            @if($loanHistory->status == 0)
                                                <td><strong style="color: #dd4b39"> Pending</strong> </td>
                                            @elseif($loanHistory->status == 1)
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
