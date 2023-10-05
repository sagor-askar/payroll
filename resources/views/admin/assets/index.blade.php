@extends('layouts.admin')
@section('content')
<div class="content">

    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
                <a class="buttonNew" href="{{ route('admin.assets.create') }}" style="color:white;">Add Assets Details</a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Assets Management List
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
                                        Asset Name
                                    </th>

                                    <th>
                                        Asset Code
                                    </th>

                                    <th>
                                        Group
                                    </th>

                                    <th>
                                        Date of Purchase
                                    </th>
                                    <th>
                                        Supplier Name
                                    </th>
                                    <th>
                                        Supplier Contact
                                    </th>
                                    <th>
                                        &nbsp;Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($assets as $key=>$asset)
                                    <tr data-entry-id="{{$asset->id}}">
                                        <td>

                                        </td>
                                        <td>
                                            {{ $asset->id }}
                                        </td>
                                        <td>
                                            {{ $asset->name }}
                                        </td>
                                        <td>
                                            {{ $asset->asset_code }}
                                        </td>
                                        <td>
                                            {{ $asset->asset_group->name }}
                                        </td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($asset->purchase_date)->format('d-m-Y') }} 
                                        </td>
                                        <td>
                                            {{ $asset->supplier_name }}
                                        </td>
                                        <td>
                                            {{ $asset->supplier_phone }}
                                        </td>
                                    
                                        <td>
                                            <a class="btn btn-xs btn-primary" href="{{ route('admin.assets.show', $asset->id)}}">
                                                {{ trans('global.view') }}
                                            </a>

                                            <a class="btn btn-xs btn-info" href="{{ route('admin.assets.edit', $asset->id) }}">
                                                {{ trans('global.edit') }}
                                            </a>

                                            <form action="{{ route('admin.assets.destroy', $asset->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                            </form>

                                        </td>

                                    </tr>
                            @endforeach


                            </tbody>
                        </table>
                        @if ($assets->hasPages())

                            {{ $assets->links() }}
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
    url: "#",
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
