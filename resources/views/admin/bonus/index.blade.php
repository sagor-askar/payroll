@extends('layouts.admin')
@section('content')
    <div class="content">
        @can('leave_application_create')
            <div style="margin-bottom: 10px;" class="row">
                <div class="col-lg-12">
                    <a class="buttonNew" href="{{ route('admin.bonus.create') }}" style="color: white;">Add Salary Bonus</a>
                </div>
            </div>
        @endcan
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{ trans('cruds.leaveApplication.title_singular') }} {{ trans('global.list') }}
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class=" table table-bordered table-striped table-hover datatable datatable-LeaveApplication">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">ID</th>
                                    <th scope="col">Employee</th>
                                    <th scope="col">Department</th>
                                    <th scope="col">Bonus Name</th>
                                    <th scope="col">Bonus Percentage</th>
                                    <th scope="col">Bonus Amount</th>
                                    <th scope="col">Bonus Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($bonusSalaryList as $key => $bonusSalary)
                                    <tr data-entry-id="{{ $bonusSalary->id }}">
                                        <td>

                                        </td>

                                        <td>
                                            {{ $bonusSalary->employee->employee_manual_id }}
                                        </td>
                                        <td>
                                            {{ $bonusSalary->employee->first_name.' '.$bonusSalary->employee->last_name }}
                                        </td>
                                        <td>
                                            {{ $bonusSalary->employee->department->department_name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $bonusSalary->bonus_name }}
                                        </td>

                                        <td>
                                            {{ $bonusSalary->bonus_percentage  }} %
                                        </td>
                                        <td>
                                            {{ $bonusSalary->amount  }}
                                        </td>

                                        <td>
                                            {{ $bonusSalary->bonus_date  }}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            @if ($bonusSalaryList->hasPages())

                                {{ $bonusSalaryList->links() }}
                            @endif
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



