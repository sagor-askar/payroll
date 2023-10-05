@extends('layouts.admin')
@section('content')
<div class="content">
    @can('attendance_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">

                    <a class="buttonNew" href="{{ route('overtime_request.create') }}" style="color: white;">
                        Add Overtime Request
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
                                        ID
                                    </th>
                                    <th>
                                        Employee ID
                                    </th>
                                    <th>
                                        Employee
                                    </th>
                                    <th>
                                        Date
                                    </th>
                                    <th>
                                        Time Slot
                                    </th>

                                    <th>
                                      Working Hour
                                    </th>
                                    <th>
                                       OT Salary
                                    </th>
                                    <th>
                                        &nbsp;Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                  @foreach($ot_details as $key=>$ot_info)
                                    <tr data-entry-id="">
                                        <td></td>
                                        <td>
                                            {{ $ot_info-> id ?? '' }}
                                        </td>
                                        <td>
                                            {{$ot_info->employee->employee_manual_id }}
                                        </td>
                                        <td>
                                            {{ $ot_info->employee->first_name.' '.$ot_info->employee->last_name}}
                                        </td>
                                        <td>
                                            {{ $ot_info->ot_date }}
                                        </td>
                                        <td>
                                            {{ $ot_info->ot_time }}
                                        </td>
                                        <td>
                                            {{ $ot_info->working_hour }}
                                        </td>
                                        <td>
                                            {{ $ot_info->ot_salary }}
                                        </td>

                                        <td>

                                <a class="btn btn-xs btn-primary" href="{{ route('overtime_request.show', $ot_info->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                    
                                    <a class="btn btn-xs btn-info" href="{{ route('overtime_request.edit', $ot_info->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>

                                    <form action="{{ route('overtime_request.destroy', $ot_info->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>

                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        @if ($ot_details->hasPages())

                            {{ $ot_details->links() }}
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
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-Attendance:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
