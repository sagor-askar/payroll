@extends('layouts.admin')
@section('content')
<div class="content">

    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
                <a class="buttonNew" href="{{ route('admin.conveyance.create') }}" style="color:white;">Add Conveyance Bill</a>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Conveyance Bill List
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-lateConsideration">
                            <thead>
                                <tr>
                                    <th width="10">

                                    </th>
                                    <th>
                                        ID
                                    </th>
                                    <th>
                                        Employee Name
                                    </th>

                                    <th>
                                        Department
                                    </th>

                                    <th>
                                        Designation
                                    </th>

                                    <th>
                                       Date
                                    </th>

                                    <th>
                                      Amount
                                    </th>



                                    <th>
                                        &nbsp;Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($conveyances as $key=>$conveyance)
                                @php
                                    $conveyance_amount = \App\Models\ConveyanceItem::where('conveyance_id', $conveyance->id)->get()->sum('cost');

                                    @endphp
                                    <tr data-entry-id="{{$conveyance->id}}">
                                        <td></td>
                                        <td>
                                            {{ $conveyance->id ?? '' }}
                                        </td>
                                        <td>
                                            {{ $conveyance->employee->first_name.' '.$conveyance->employee->last_name}}
                                        </td>

                                        <td>
                                            {{ $conveyance->department->department_name}}
                                        </td>

                                        <td>
                                            {{ $conveyance->designation->designation_name }}
                                        </td>

                                        <td>
                                          {{ $conveyance->conveyance_date }}
                                        </td>
                                        <td>
                                        {{ $conveyance_amount }}
                                        </td>

                                        <td>
                                            <a class="btn btn-xs btn-primary" href="{{ route('admin.conveyance.show', $conveyance->id) }}">
                                                {{ trans('global.view') }}
                                            </a>

                                            <a class="btn btn-xs btn-info" href="{{ route('admin.conveyance.edit', $conveyance->id) }}">
                                                {{ trans('global.edit') }}
                                            </a>

                                            <form action="{{ route('admin.conveyance.destroy', $conveyance->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                            </form>

                                        </td>

                                    </tr>

                                @endforeach
                            </tbody>
                        </table>
                        @if ($conveyances->hasPages())

                            {{ $conveyances->links() }}
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


  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ '1', 'desc' ]],
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
