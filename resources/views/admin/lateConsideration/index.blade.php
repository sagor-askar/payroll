@extends('layouts.admin')
@section('content')
<div class="content">
    @can('late_consideration_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
                <a class="buttonNew" href="{{ route('admin.late-consideration.create') }}" style="color:white;">Add Request</a>
        </div>
    </div>
    @endcan


    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Request List
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-lateConsideration">
                            <thead>
                                <tr>
                                    <th width="10">

                                    </th>
                                    <th>
                                        Name
                                    </th>
                                    <th>
                                        Date
                                    </th>
                                    <th>
                                        Clock In
                                    </th>
                                    <th>
                                        Clock Out
                                    </th>
                                    <th>
                                        Approved By
                                    </th>
                                    <th>
                                        Reason
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

                            @foreach($lateConsider as $key=> $value)
                                    <tr data-entry-id="{{$value->id}}">
                                        <td>

                                        </td>
                                        <td>
                                           {{$value->employee->first_name.' '.$value->employee->last_name}}
                                        </td>
                                        <td>
                                            {{$value->date}}
                                        </td>
                                        <td>
                                            {{$value->clock_in}}
                                        </td>
                                        <td>
                                            {{$value->clock_out}}
                                        </td>
                                        <td>
                                            {{$value->approved_employee->first_name.' '.$value->approved_employee->last_name}}

                                        </td>
                                        <td>
                                            {{$value->reason}}
                                        </td>
                                        @if($value->status == 0)
                                            <td><strong style="color: #dd4b39"> Pending</strong> </td>
                                        @elseif($value->status == 1)
                                            <td><strong style="color: darkgreen"> Approved</strong> </td>
                                        @else
                                            <td><strong style="color: red"> Rejected</strong> </td>
                                        @endif
                                        <td>

                                            @can('late_consideration_show')
                                             @if($value->status != 2)
                                                <a class="btn btn-xs btn-primary" href="{{ route('admin.late-consideration.show', $value->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                             @endif
                                            @endcan

                                           @can('late_consideration_edit')
                                            @if($value->status == 0)
                                                    <a class="btn btn-xs btn-info" href="{{ route('admin.late-consideration.edit', $value->id) }}">
                                                        {{ trans('global.edit') }}
                                                    </a>
                                            @endif
                                           @endcan
                                            @can('late_consideration_delete')
                                                <form action="{{ route('admin.late-consideration.destroy', $value->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
                        @if ($lateConsider->hasPages())

                            {{ $lateConsider->links() }}
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
    @can('late_consideration_delete')
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
    //order: [[ '1', 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-lateConsideration:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
