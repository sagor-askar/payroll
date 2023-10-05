@extends('layouts.admin')
@section('content')
<div class="content">
    @can('roster_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                    <a class="buttonNew" href="{{ route('admin.rosters.create') }}" style="color: white;">
                        Add Roster
                    </a>
            </div>
        </div>
    @endcan
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    List Roster
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-roster">
                            <thead>
                                <tr>
                                    <th width="10">

                                    </th>
                                    <th>
                                       Employee ID
                                    </th>
                                    <th>
                                       Name
                                    </th>
                                    <th>
                                        Date
                                    </th>
                                    <th>
                                       Start Time
                                    </th>
                                    <th>
                                        End Time
                                    </th>
                                    {{-- <th>
                                        &nbsp;Action
                                    </th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rosters as $key => $roster)
                                    <tr data-entry-id="{{ $roster->id }}">
                                        <td>

                                        </td>
                                        <td>
                                            {{ $roster->employee->employee_manual_id ?? '' }}
                                        </td>
                                        <td>
                                            {{ $roster->employee->first_name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $roster->duty_date ?? '' }}
                                        </td>
                                        <td>
                                            {{ $roster->start_time ?? '' }}
                                        </td>
                                        <td>
                                            {{ $roster->end_time ?? '' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if ($rosters->hasPages())

                            {{ $rosters->links() }}
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
@can('roster_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "",
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
  let table = $('.datatable-roster:not(.ajaxTable)').DataTable()
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
