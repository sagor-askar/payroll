@extends('layouts.admin')
@section('content')
<div class="content">
    @can('sub_company_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">

                    <a class="buttonNew" href="{{ route('admin.sub-companies.create') }}" style="color: white;">
                        Add Sub Company
                    </a>

            </div>
        </div>
    @endcan
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('cruds.subCompany.title_singular') }} {{ trans('global.list') }}
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover datatable datatable-SubCompany" id="subCompany-dataTable">
                            <thead>
                                <tr>
                                    <th>
                                        
                                    </th>
                                    <th>
                                        {{ trans('cruds.subCompany.fields.company') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.subCompany.fields.sub_company_name') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.subCompany.fields.sub_company_address') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.subCompany.fields.contact_no') }}
                                    </th>
                                    <th>
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($subCompanies as $key => $subCompany)
                                    <tr data-entry-id="{{ $subCompany->id }}">
                                        <td>

                                        </td>
                                        <td>
                                            {{ $subCompany->company->comp_name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $subCompany->sub_company_name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $subCompany->sub_company_address ?? '' }}
                                        </td>
                                        <td>
                                            {{ $subCompany->contact_no ?? '' }}
                                        </td>
                                        <td>
                                            @can('sub_company_show')
                                                <a class="btn btn-xs btn-primary" href="{{ route('admin.sub-companies.show', $subCompany->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endcan

                                            @can('sub_company_edit')
                                                <a class="btn btn-xs btn-info" href="{{ route('admin.sub-companies.edit', $subCompany->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                            @endcan

                                            @can('sub_company_delete')
                                                <form action="{{ route('admin.sub-companies.destroy', $subCompany->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
                        @if ($subCompanies->hasPages())

                            {{ $subCompanies->links() }}
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
@can('sub_company_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.sub-companies.massDestroy') }}",
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
  let table = $('.datatable-SubCompany:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>

@endsection
