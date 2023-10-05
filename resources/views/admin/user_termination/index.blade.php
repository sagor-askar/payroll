@extends('layouts.admin')
@section('content')
    <div class="content">
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="buttonNew" href="{{ route('admin.terminations.create') }}" style="color: white;">
                    Add Deboarding
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Deboarding {{ trans('global.list') }}
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class=" table table-bordered table-striped table-hover datatable datatable-LeaveApplication">
                                <thead>
                                <tr>
                                    <th width="10">

                                    </th>
                                    <th>
                                        {{ trans('cruds.user.fields.id') }}
                                    </th>
                                    <th>
                                        Employee Name
                                    </th>
                                    <th>
                                        Reason
                                    </th>
                                    <th>
                                        Notice Date
                                    </th>
                                    <th>
                                        Termination Date
                                    </th>
                                    <th>
                                        Details
                                    </th>

                                    <th>
                                        Status
                                    </th>
                                    <th>
                                        Action
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($userterminations as $key => $termination)
                                    <tr data-entry-id="{{ $termination->id }}">
                                        <td>

                                        </td>
                                        <td>
                                            {{ $termination->id ?? '' }}
                                        </td>
                                        <td>
                                            {{ $termination->employee->first_name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $termination->termination_reason ?? '' }}
                                        </td>
                                        <td>
                                            {{ $termination->notice_date ?? '' }}
                                        </td>
                                        <td>
                                            {{ $termination->terminatation_date ?? '' }}
                                        </td>
                                        <td>
                                            {!! $termination->details !!}
                                        </td>
                                       @if($termination->is_active == 0)
                                        <td style="color: green">Not Terminated </td>
                                        @else
                                            <td style="color: red"> Terminated </td>
                                       @endif

                                        <td>

                                            <a class="btn btn-xs btn-info" href="{{ route('admin.terminations.edit', $termination->id) }}">
                                                {{ trans('global.edit') }}
                                            </a>
                                            <a class="btn btn-xs btn-primary" href="{{ route('admin.terminations.show', $termination->id) }}">
                                                {{ trans('global.view') }}
                                            </a>

                                            <a class="btn btn-xs btn-warning" href="{{ route('admin.terminations.changeStatus', $termination->id) }}">
                                                ChangeStatus
                                            </a>


{{--                                            @can('user_delete')--}}
{{--                                                <form action="{{ route('admin.terminations.destroy', $termination->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">--}}
{{--                                                    <input type="hidden" name="_method" value="DELETE">--}}
{{--                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
{{--                                                    <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">--}}
{{--                                                </form>--}}
{{--                                            @endcan--}}

                                        </td>

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
@endsection
@section('scripts')
    @parent
    <script>
        $(function () {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('leave_application_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.leave-applications.massDestroy') }}",
                className: 'btn-danger',
                action: function (e, dt, node, config) {
                    var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
                        return $(entry).data('entry-id')
                    });

                    if (ids.length === 0) {
                        alert('{{ trans('global.datatables.zero_selected') }}')

                        return
                    }

                    if (confirm('{{ trans('global.areYouSure') }}')) {
                        $.ajax({
                            headers: {'x-csrf-token': _token},
                            method: 'POST',
                            url: config.url,
                            data: { ids: ids, _method: 'DELETE' }})
                            .done(function () { location.reload() })
                    }
                }
            }
            dtButtons.push(deleteButton)
            @endcan
            $.extend(true, $.fn.dataTable.defaults, {
                orderCellsTop: true,
                order: [[ 1, 'desc' ]],
                pageLength: 100,
            });
            let table = $('.datatable-LeaveApplication:not(.ajaxTable)').DataTable({ buttons: dtButtons })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })
    </script>

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
@endsection

