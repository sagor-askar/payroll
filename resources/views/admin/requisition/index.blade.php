@extends('layouts.admin')
@section('content')
<div class="content">
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
                <a class="buttonNew" href="{{ route('admin.requisition.create') }}" style="color:white;">Add Request</a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Requisition List
                </div>

                <div class="panel-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-LeaveType">
                            <thead>
                                <tr>
                                    <th width="10">
                                    </th>
                                    <th>
                                        ID
                                    </th>
                                    <th>
                                        Requesting Person
                                    </th>
                                    <th>
                                        Department
                                    </th>
                                    <th>
                                        Expected Time Starts
                                    </th>
                                    <th>
                                        Expected Time Ends
                                    </th>
                                    <th>
                                        Quantity
                                    </th>
                                    <th>
                                        Price
                                    </th>
                                    <th>
                                        status
                                    </th>
                                    <th>
                                        &nbsp;Action
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                            @foreach($requisitions as $key=> $requisition)
                                @php
                                $requisition_items = \App\Models\RequisitionItems::where('requisition_id',$requisition->id)->get();
                               $toal_qty = $requisition_items->sum('qty');
                               $total_price = $requisition_items->sum('unit_price');
                                @endphp
                                    <tr data-entry-id="{{$requisition->id}}">
                                        <td>
                                        </td>
                                        <td>
                                            {{ $requisition->id }}
                                        </td>
                                        <td>
                                            {{ $requisition->employee->first_name.' '.$requisition->employee->last_name}}
                                        </td>
                                        <td>
                                            {{ $requisition->department->department_name}}
                                        </td>
                                        <td>
                                            {{ $requisition->start_date}}
                                        </td>
                                        <td>
                                            {{ $requisition->end_date}}
                                        </td>
                                        <td>
                                            {{$toal_qty}}
                                        </td>
                                        <td>
                                            {{$total_price}}
                                        </td>

                                        @if($requisition->status == 0)
                                            <td><strong style="color: #dd4b39"> Pending</strong> </td>
                                        @elseif($requisition->status == 1)
                                            <td><strong style="color: darkgreen"> Approved</strong> </td>
                                        @else
                                            <td><strong style="color: red"> Rejected</strong> </td>
                                        @endif

                                        <td>
                                            <a class="btn btn-xs btn-primary" href="{{ route('admin.requisition.show',$requisition->id)}}">
                                                {{ trans('global.view') }}
                                            </a>
                                            <a class="btn btn-xs btn-info" href="{{ route('admin.requisition.edit', $requisition->id) }}">
                                                {{ trans('global.edit') }}
                                            </a>
                                            <form action="{{ route('admin.requisition.destroy', $requisition->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                            </form>
                                        </td>
                                    </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @if ($requisitions->hasPages())

                            {{ $requisitions->links() }}
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
