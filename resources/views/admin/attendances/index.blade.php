@extends('layouts.admin')
@section('content')
<div class="content">
    @can('attendance_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">

                    <a class="buttonNew" href="{{ route('admin.attendances.create') }}" style="color: white;">
                        Add Attendance
                    </a>

            </div>
        </div>
    @endcan
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('cruds.attendance.title_singular') }} {{ trans('global.list') }}
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-Attendance">
                            <thead>
                                <tr>
                                    <th width="10">

                                    </th>
                                    
                                    <th>
                                        {{ trans('cruds.attendance.fields.employee') }}
                                    </th>
                                    <th>
                                       Attendance Type
                                    </th>
                                    <th>
                                        {{ trans('cruds.attendance.fields.date') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.attendance.fields.clock_in') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.attendance.fields.clock_out') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.attendance.fields.late') }}
                                    </th>
                                    
                                    <th>
                                        {{ trans('cruds.attendance.fields.total_work') }}
                                    </th>
                                    <th>
                                       Device
                                    </th>
                                    <th>
                                        Att. Area
                                    </th>
                                    <th>
                                        Leave Area
                                    </th>
                                    <th>
                                        Status
                                    </th>
                                    <th>
                                        &nbsp;Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($attendances as $key => $attendance)
                                    <tr data-entry-id="{{ $attendance->id }}">
                                        <td>

                                        </td>
                                        <td>
                                            {{ $attendance->employee->first_name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $attendance->employee->attendance_type ?? '' }}  @if($attendance->employee->attendance_type == 'Shift')(  {{ $attendance->employee->shift->name ?? '' }}) @endif
                                        </td>
                                        <td>
                                            {{ $attendance->date ?? '' }}
                                        </td>
                                        <td>
                                            {{ $attendance->clock_in ?? '' }}
                                        </td>
                                        <td>
                                            {{ $attendance->clock_out ?? '' }}
                                        </td>
                                        <td>
                                            {{ $attendance->late ?? '' }}
                                        </td>
                                        <td>
                                            {{ $attendance->total_work ?? '' }}
                                        </td>
                                        <td>
                                            {{ $attendance->device_name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $attendance->area ?? '' }}
                                        </td>
                                        <td>
                                            {{ $attendance->leave_location ?? '' }}
                                        </td>
                                        @if ($attendance->late == null)
                                        <td style="color: green">Present</td>
                                        @else
                                        <td style="color: red">Late</td>
                                        @endif
                                        <td>
                                            @can('attendance_show')
                                                <a class="btn btn-xs btn-primary" href="{{ route('admin.attendances.show', $attendance->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endcan

                                            @can('attendance_edit')
                                                <a class="btn btn-xs btn-info" href="{{ route('admin.attendances.edit', $attendance->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                            @endcan

                                            @can('attendance_delete')
                                                <form action="{{ route('admin.attendances.destroy', $attendance->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                                </form>
                                            @endcan

                                        </td>

                                    </tr>
                                @endforeach

                            </tbody>

                        </table>
                        @if ($attendances->hasPages())

                        {{ $attendances->links() }}
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
    @can('attendance_delete')
    let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
    let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.attendances.massDestroy') }}",
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
    //  order: [[ 1, 'asc' ]],
    pageLength: 100,
    paging:   false,
  });
  let table = $('.datatable-Attendance:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
