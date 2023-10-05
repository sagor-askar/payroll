@extends('layouts.admin')
@section('content')
<div class="content">
    @can('department_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">

                    <a class="buttonNew" href="{{ route('admin.departments.create') }}" style="color: white;">
                        Add Department
                    </a>

            </div>
        </div>
    @endcan
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('cruds.department.title_singular') }} {{ trans('global.list') }}
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-Department">
                            <thead>
                                <tr>
                                    <th width="10">

                                    </th>
                                    <th>
                                        {{ trans('cruds.department.fields.id') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.department.fields.company') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.department.fields.sub_company') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.department.fields.branch') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.department.fields.department_name') }}
                                    </th>
                                    <th>
                                        &nbsp;Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($departments as $key => $department)
                                    <tr data-entry-id="{{ $department->id }}">
                                        <td>

                                        </td>
                                        <td>
                                            {{ $department->id ?? '' }}
                                        </td>
                                        <td>
                                            {{ $department->company->comp_name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $department->sub_company->sub_company_name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $department->branch->branch_name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $department->department_name ?? '' }}
                                        </td>
                                        <td>
                                            @can('department_show')
                                                <a class="btn btn-xs btn-primary" href="{{ route('admin.departments.show', $department->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endcan

                                            @can('department_edit')
                                                <a class="btn btn-xs btn-info" href="{{ route('admin.departments.edit', $department->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                            @endcan

                                            @can('department_delete')
                                                <form action="{{ route('admin.departments.destroy', $department->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
                        @if ($departments->hasPages())

                            {{ $departments->links() }}
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
@can('department_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.departments.massDestroy') }}",
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
  let table = $('.datatable-Department:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
