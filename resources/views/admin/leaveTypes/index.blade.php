@extends('layouts.admin')
@section('content')
<div class="content">
    @can('leave_type_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">

                    <a class="buttonNew" href="{{ route('admin.leave-types.create') }}" style="color: white;">Add Leave Type</a>

            </div>
        </div>
    @endcan
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('cruds.leaveType.title_singular') }} {{ trans('global.list') }}
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-LeaveType">
                            <thead>
                                <tr>
                                    <th width="10">

                                    </th>
                                    <th>
                                        {{ trans('cruds.leaveType.fields.id') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.leaveType.fields.company') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.leaveType.fields.sub_company_id') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.leaveType.fields.leave_name') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.leaveType.fields.no_of_days') }}
                                    </th>
                                    <th>
                                        &nbsp;Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($leaveTypes as $key => $leaveType)
                                    <tr data-entry-id="{{ $leaveType->id }}">
                                        <td>

                                        </td>
                                        <td>
                                            {{ $leaveType->id ?? '' }}
                                        </td>
                                        <td>
                                            {{ $leaveType->company->comp_name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $leaveType->subcompany->sub_company_name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $leaveType->leave_name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $leaveType->no_of_days ?? '' }}
                                        </td>
                                        <td>
                                            @can('leave_type_show')
                                                <a class="btn btn-xs btn-primary" href="{{ route('admin.leave-types.show', $leaveType->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endcan

                                            @can('leave_type_edit')
                                                <a class="btn btn-xs btn-info" href="{{ route('admin.leave-types.edit', $leaveType->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                            @endcan

                                            @can('leave_type_delete')
                                                <form action="{{ route('admin.leave-types.destroy', $leaveType->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
                        @if ($leaveTypes->hasPages())

                            {{ $leaveTypes->links() }}
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
    @can('leave_type_delete')
    let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
    let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.leave-types.massDestroy') }}",
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
  let table = $('.datatable-LeaveType:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
