@extends('layouts.admin')
@section('content')
<div class="content">
    @can('leave_application_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">

                    <a class="buttonNew" href="{{ route('admin.leave-applications.create') }}" style="color: white;">Add Leave Application</a>

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
                                    <th width="10">

                                    </th>
                                    <th>
                                        {{ trans('cruds.leaveApplication.fields.employee') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.leaveApplication.fields.department') }}
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
                                      No Of Days
                                    </th>
{{--                                    <th>--}}
{{--                                        {{ trans('cruds.leaveApplication.fields.doc') }}--}}
{{--                                    </th>--}}
                                    <th>
                                        {{ trans('cruds.leaveApplication.fields.status') }}
                                    </th>
                                    <th>
                                        &nbsp;Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($leaveApplications as $key => $leaveApplication)
                                    <tr data-entry-id="{{ $leaveApplication->id }}">
                                        <td>

                                        </td>
                                        <td>
                                            {{ $leaveApplication->employee->first_name.' '.$leaveApplication->employee->last_name }}
                                        </td>
                                        <td>
                                            {{ $leaveApplication->department->department_name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $leaveApplication->assign_employee->first_name.' '.$leaveApplication->assign_employee->last_name }}
                                        </td>

                                        <td>
                                            {{ $leaveApplication->leave_type->leave_name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $leaveApplication->start_date ?? '' }}
                                        </td>
                                        <td>
                                            {{ $leaveApplication->end_date ?? '' }}
                                        </td>
                                        <td>
                                            {{ $leaveApplication->no_of_days ?? '' }}
                                        </td>
                                            @if($leaveApplication->status == 0)
                                            <td><strong style="color: #dd4b39"> Pending</strong> </td>
                                            @elseif($leaveApplication->status == 1)
                                            <td><strong style="color: darkgreen"> Approved</strong> </td>
                                            @else
                                            <td><strong style="color: red"> Rejected</strong> </td>
                                            @endif
                                          <td>
                                              @if($leaveApplication->status != 2)
                                                  @can('leave_application_show')
                                                      <a class="btn btn-xs btn-primary" href="{{ route('admin.leave-applications.show', $leaveApplication->id) }}">
                                                          {{ trans('global.view') }}
                                                      </a>
                                                  @endcan
                                              @endif
                                              @if($leaveApplication->status == 0)
                                                  @can('leave_application_edit')
                                                      <a class="btn btn-xs btn-info" href="{{ route('admin.leave-applications.edit', $leaveApplication->id) }}">
                                                          {{ trans('global.edit') }}
                                                      </a>
                                                  @endcan
                                              @endif
                                              @if ($leaveApplication->status != 1)
                                                @can('leave_application_delete')
                                                    <form action="{{ route('admin.leave-applications.destroy', $leaveApplication->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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

                        @if ($leaveApplications->hasPages())

                            {{ $leaveApplications->links() }}
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
