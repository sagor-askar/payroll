@extends('layouts.admin')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Provident Fund  History
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="form-group">
                                <a class="btn btn-default" href="{{ route('admin.loan.index') }}">
                                    {{ trans('global.back_to_list') }}
                                </a>
                            </div>

                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                            <tr>
                                <th>
                                    Employee Id
                                </th>
                                <td>
                                    {{ $providents[0]->employee->employee_manual_id }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.leaveApplication.fields.employee') }}
                                </th>
                                <td>
                                    {{ $providents[0]->employee->first_name .' '.$providents[0]->employee->last_name }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.leaveApplication.fields.department') }}
                                </th>
                                <td>
                                    {{ $providents[0]->employee->department->department_name ?? '' }}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <h4 style="text-align: center"> <strong>Provident Fund History</strong></h4>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class=" table table-bordered table-striped table-hover datatable datatable-LeaveApplication">
                                    <thead>
                                    <tr>
                                        <th width="10">

                                        </th>
                                        <th>
                                          SL
                                        </th>
                                        <th>
                                            Date
                                        </th>
                                        <th>
                                            Provident Fund Amount
                                        </th>
                                        <th>
                                            Company Contribution
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($providents as $key => $value)
                                        <tr data-entry-id="{{ $value->id }}">
                                            <td>

                                            </td>
                                            <td>
                                                {{$key+1}}
                                            </td>
                                            <td>
                                                {{ $value->pf_date }}
                                            </td>
                                            <td>
                                                {{ $value->pf_amount }}
                                            </td>
                                            <td>
                                                {{ $value->company_amount ?? '' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                @if ($providents->hasPages())

                                    {{ $providents->links() }}
                                @endif
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
