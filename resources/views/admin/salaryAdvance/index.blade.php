@extends('layouts.admin')
@section('content')
<div class="content">
    @can('salary_advance_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">

                    <a class="buttonNew" href="{{ route('admin.salary-advance.create') }}" style="color: white;">Add Salary Advance</a>

            </div>
        </div>
    @endcan
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                 Advance Salary {{ trans('global.list') }}
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-LeaveApplication">
                            <thead>
                                <tr>
                                    <th width="10">

                                    </th>
                                    <th>
                                        ID
                                    </th>
                                    <th>
                                        Department
                                    </th>
                                    <th>
                                        Employee
                                    </th>
                                    <th>
                                        Date
                                    </th>
                                    <th>
                                        Amount
                                    </th>
                                    <th>
                                       Paid Status
                                    </th>
                                    <th>
                                       Approved Status
                                    </th>
                                    <th>
                                        Created By
                                    </th>

                                    <th>
                                        &nbsp;Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($salaryAdvance_list as $key => $advance_salary)
                                    <tr data-entry-id="{{ $advance_salary->id }}">
                                        <td>

                                        </td>
                                        <td>
                                            {{ $advance_salary->id }}
                                        </td>
                                        <td>
                                            {{ $advance_salary->employee->department->department_name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $advance_salary->employee->first_name.' '.$advance_salary->employee->last_name }}
                                        </td>
                                        <td>
                                            {{ $advance_salary->sd_date ?? '' }}
                                        </td>
                                        <td>
                                            {{ $advance_salary->amount ?? '' }}
                                        </td>

                                        @if($advance_salary->paid_status == 0)
                                            <td><strong style="color: #dd4b39"> Unpaid</strong> </td>
                                        @else
                                            <td><strong style="color: darkgreen"> Paid</strong> </td>
                                        @endif


                                        @if($advance_salary->status == 0)
                                            <td><strong style="color: #dd4b39"> Pending</strong> </td>
                                        @elseif($advance_salary->status == 1)
                                            <td><strong style="color: darkgreen"> Approved</strong> </td>
                                        @else
                                            <td><strong style="color: red"> Rejected</strong> </td>
                                        @endif

                                            <td>
                                                {{ $advance_salary->user->name ?? '' }}
                                            </td>

                                          <td>
                                            @can('salary_advance_show')
                                            <a class="btn btn-xs btn-primary" href="{{ route('admin.salary-advance.show', $advance_salary->id) }}">
                                                {{ trans('global.view') }}
                                            </a>
                                            @endcan
                                            @if ($advance_salary->status != 1)
                                                @can('salary_advance_edit')
                                                <a class="btn btn-xs btn-info" href="{{ route('admin.salary-advance.edit', $advance_salary->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                                @endcan
                                            @endif

                                            @if ($advance_salary->status != 1)
                                                @can('salary_advance_delete')
                                                <form action="{{ route('admin.salary-advance.destroy', $advance_salary->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                                </form>
                                                @endcan
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if ($salaryAdvance_list->hasPages())

                            {{ $salaryAdvance_list->links() }}
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
@can('salary_advance_delete')
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
