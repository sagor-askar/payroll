@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.show') }} Promotion History
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.promotion.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        </div>
                    <h4 style="text-align: left"> <strong>Employee Promotion Status</strong></h4>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                       Employee Id
                                    </th>
                                    <td>
                                        {{ $promotionData->employee->employee_manual_id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.leaveApplication.fields.employee') }}
                                    </th>
                                    <td>
                                        {{ $promotionData->employee->first_name .' '.$promotionData->employee->last_name }}
                                    </td>
                                </tr>

                                <tr>
                                    <th>
                                        {{ trans('cruds.leaveApplication.fields.department') }}
                                    </th>
                                    <td>
                                        {{ $promotionData->employee->department->department_name ?? '' }}
                                    </td>
                                </tr>

                                <tr>
                                    <th>
                                       Designation
                                    </th>
                                    <td>
                                        {{ $promotionData->employee->designation->designation_name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                       Grade
                                    </th>
                                    <td>
                                        {{ $promotionData->employee->grade->grade ?? '' }}
                                    </td>
                                </tr>

                                <tr>
                                    <th>
                                      Salary
                                    </th>
                                    <td>
                                        {{ $promotionData->employee->salary }}
                                    </td>
                                </tr>


                                <tr>
                                    <th>
                                       Promotion Date
                                    </th>
                                    <td>
                                        {{ $promotionData->promotion_date ?? '' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    <div >
                        <h4 style="text-align: center"> <strong>Promotion History</strong></h4>
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
                                            Designation
                                        </th>
                                        <th>
                                           Grade
                                        </th>
                                        <th>
                                         Previous  Date
                                        </th>

                                        <th>
                                            Promotion Amount
                                        </th>

                                        <th>
                                         Promotion Date
                                        </th>
                                        <th>
                                            Promoted By
                                        </th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($promotion_history as $key => $proHistory)
                                        <tr data-entry-id="{{ $proHistory->id }}">
                                            <td>

                                            </td>
                                            <td>
                                                {{ $proHistory->employee->first_name.' '.$proHistory->employee->last_name }}
                                            </td>
                                            <td>
                                                {{ $proHistory->department->department_name ?? '' }}
                                            </td>
                                            <td>
                                                {{ $proHistory->designation->designation_name ?? '' }}
                                            </td>
                                            <td>
                                                {{ $proHistory->grade->grade ?? '' }}
                                            </td>

                                            <td>
                                                {{ $proHistory->previous_date ?? '' }}
                                            </td>

                                            <td>
                                                {{ $proHistory->promotion_amount ?? '' }}
                                            </td>

                                            <td>
                                                {{ $proHistory->promotion_date ?? '' }}
                                            </td>

                                            <td>
                                                {{ $proHistory->promoted_by->created_by ?? '' }}
                                            </td>



                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.promotion.index') }}">
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
