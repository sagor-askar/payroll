@extends('layouts.admin')
@section('content')
<div class="content">
    @if($lims_total_percentage < 100)
    @can('salary_allowance_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">

                    <a class="buttonNew" href="{{ route('admin.salary-allowances.create') }}" style="color: white;">
                        Add Salary Allowance
                    </a>


            </div>
        </div>
    @endcan
    @else
        @can('salary_allowance_create')
            <div style="margin-bottom: 10px;" class="row" disabled>
                <div class="col-lg-12">
                    <a disabled class="btn btn-success" href="#">
                     Your limit is over !
                    </a>
                </div>
            </div>
        @endcan
 @endif
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('cruds.salaryAllowance.title_singular') }} {{ trans('global.list') }}
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-SalaryAllowance">
                            <thead>
                                <tr>
                                    <th width="10">

                                    </th>
                                    <th>
                                        {{ trans('cruds.salaryAllowance.fields.id') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.salaryAllowance.fields.company') }}
                                    </th>

                                    <th>
                                        {{ trans('cruds.salaryAllowance.fields.allowance_name') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.salaryAllowance.fields.percentage') }}
                                    </th>


                                    <th>

                                        &nbsp;Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($salaryAllowances as $key => $salaryAllowance)
                                    <tr data-entry-id="{{ $salaryAllowance->id }}">
                                        <td>

                                        </td>
                                        <td>
                                            {{ $salaryAllowance->id ?? '' }}
                                        </td>

                                        <td>
                                            {{ $salaryAllowance->company->comp_name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $salaryAllowance->allowance_name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $salaryAllowance->percentage ?? '' }} %
                                        </td>


                                        <td>
                                            @can('salary_allowance_show')
                                                <a class="btn btn-xs btn-primary" href="{{ route('admin.salary-allowances.show', $salaryAllowance->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endcan

                                            @can('salary_allowance_edit')
                                                <a class="btn btn-xs btn-info" href="{{ route('admin.salary-allowances.edit', $salaryAllowance->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                            @endcan

                                            @can('salary_allowance_delete')
                                                <form action="{{ route('admin.salary-allowances.destroy', $salaryAllowance->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
                        @if ($salaryAllowances->hasPages())

                            {{ $salaryAllowances->links() }}
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
@can('salary_allowance_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.salary-allowances.massDestroy') }}",
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
  let table = $('.datatable-SalaryAllowance:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
