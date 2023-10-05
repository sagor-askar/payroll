@extends('layouts.admin')
@section('content')
<div class="content">
    @can('holiday_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">

                    <a class="buttonNew" href="{{ route('admin.holidays.create') }}" style="color:white;">Add Holiday</a>

            </div>
        </div>
    @endcan
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('cruds.holiday.title_singular') }} {{ trans('global.list') }}
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-Holiday">
                            <thead>
                                <tr>
                                    <th width="10">

                                    </th>
                                    <th>
                                        {{ trans('cruds.holiday.fields.id') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.holiday.fields.department') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.holiday.fields.company') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.holiday.fields.holiday_name') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.holiday.fields.from_holiday') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.holiday.fields.to_holiday') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.holiday.fields.number_of_days') }}
                                    </th>
                                    <th>
                                        &nbsp;Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($holidays as $key => $holiday)
                                    <tr data-entry-id="{{ $holiday->id }}">
                                        <td>

                                        </td>
                                        <td>
                                            {{ $holiday->id ?? '' }}
                                        </td>
                                        <td>
                                            {{ $holiday->department->department_name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $holiday->company->comp_name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $holiday->holiday_name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $holiday->from_holiday ?? '' }}
                                        </td>
                                        <td>
                                            {{ $holiday->to_holiday ?? '' }}
                                        </td>
                                        <td>
                                            {{ $holiday->number_of_days ?? '' }}
                                        </td>
                                        <td>
                                            @can('holiday_show')
                                                <a class="btn btn-xs btn-primary" href="{{ route('admin.holidays.show', $holiday->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endcan

                                            @can('holiday_edit')
                                                <a class="btn btn-xs btn-info" href="{{ route('admin.holidays.edit', $holiday->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                            @endcan

                                            @can('holiday_delete')
                                                <form action="{{ route('admin.holidays.destroy', $holiday->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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

                        @if ($holidays->hasPages())

                            {{ $holidays->links() }}
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
@can('holiday_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.holidays.massDestroy') }}",
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
  let table = $('.datatable-Holiday:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
