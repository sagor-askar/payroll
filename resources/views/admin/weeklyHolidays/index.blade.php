@extends('layouts.admin')
@section('content')
<div class="content">
    @can('weekly_holiday_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">

                    <a class="buttonNew" href="{{ route('admin.weekly-holidays.create') }}" style="color: white;">Add Weekly Holidays</a>

            </div>
        </div>
    @endcan
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('cruds.weeklyHoliday.title_singular') }} {{ trans('global.list') }}
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-WeeklyHoliday">
                            <thead>
                                <tr>
                                    <th width="10">

                                    </th>
                                    <th>
                                        {{ trans('cruds.weeklyHoliday.fields.id') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.weeklyHoliday.fields.department') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.weeklyHoliday.fields.company') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.weeklyHoliday.fields.weeklyleave') }}
                                    </th>
                                    <th>
                                        &nbsp;Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($weeklyHolidays as $key => $weeklyHoliday)
                                    <tr data-entry-id="{{ $weeklyHoliday->id }}">
                                        <td>

                                        </td>
                                        <td>
                                            {{ $weeklyHoliday->id ?? '' }}
                                        </td>
                                        <td>
                                            {{ $weeklyHoliday->department->department_name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $weeklyHoliday->company->comp_name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $weeklyHoliday->weeklyleave ?? '' }}
                                        </td>
                                        <td>
                                            @can('weekly_holiday_show')
                                                <a class="btn btn-xs btn-primary" href="{{ route('admin.weekly-holidays.show', $weeklyHoliday->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endcan

                                            @can('weekly_holiday_edit')
                                                <a class="btn btn-xs btn-info" href="{{ route('admin.weekly-holidays.edit', $weeklyHoliday->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                            @endcan

                                            @can('weekly_holiday_delete')
                                                <form action="{{ route('admin.weekly-holidays.destroy', $weeklyHoliday->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
                        @if ($weeklyHolidays->hasPages())

                            {{ $weeklyHolidays->links() }}
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
@can('weekly_holiday_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.weekly-holidays.massDestroy') }}",
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
  let table = $('.datatable-WeeklyHoliday:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
