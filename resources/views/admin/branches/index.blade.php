@extends('layouts.admin')
@section('content')
<div class="content">
    @can('branch_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">

                    <a class="buttonNew" href="{{ route('admin.branches.create') }}" style="color: white;">
                        Add Branch
                    </a>

            </div>
        </div>
    @endcan
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('cruds.branch.title_singular') }} {{ trans('global.list') }}
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-Branch">
                            <thead>
                                <tr>
                                    <th width="10">

                                    </th>
                                    <th>
                                        {{ trans('cruds.branch.fields.id') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.branch.fields.company') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.branch.fields.sub_company') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.branch.fields.branch_name') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.branch.fields.branch_address') }}
                                    </th>
                                    <th>
                                        &nbsp;Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($branches as $key => $branch)
                                    <tr data-entry-id="{{ $branch->id }}">
                                        <td>

                                        </td>
                                        <td>
                                            {{ $branch->id ?? '' }}
                                        </td>
                                        <td>
                                            {{ $branch->company->comp_name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $branch->sub_company->sub_company_name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $branch->branch_name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $branch->branch_address ?? '' }}
                                        </td>
                                        <td>
                                            @can('branch_show')
                                                <a class="btn btn-xs btn-primary" href="{{ route('admin.branches.show', $branch->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endcan

                                            @can('branch_edit')
                                                <a class="btn btn-xs btn-info" href="{{ route('admin.branches.edit', $branch->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                            @endcan

                                            @can('branch_delete')
                                                <form action="{{ route('admin.branches.destroy', $branch->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
                        @if ($branches->hasPages())

                            {{ $branches->links() }}
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
@can('branch_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.branches.massDestroy') }}",
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
  let table = $('.datatable-Branch:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
