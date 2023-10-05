@extends('layouts.admin')
@section('content')
<div class="content">
    @can('additional_deduction_distribution_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">

                <a class="buttonNew" href="{{ route('admin.deduction-penalties.create') }}" style="color:white;">Add Deduction Distribution</a>

        </div>
    </div>
    @endcan
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    List in Details
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-LeaveType">
                            <thead>
                                <tr>
                                    <th width="10">

                                    </th>
                                    <td>
                                        ID
                                    </td>
                                    <td>
                                        Employee ID
                                    </td>
                                    <th>
                                        Employee Name
                                    </th>
                                    <th>
                                        Deduction Name
                                    </th>
                                    <th>
                                        Deduction Amount
                                    </th>
                                    <th>
                                       Date
                                    </th>

                                    <th>
                                        &nbsp;Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($deductionPenalties as $key=>$deductionPenaltiesSetup)
                                    <tr data-entry-id="{{ $deductionPenaltiesSetup->id }}">

                                        <td>

                                        </td>
                                        <td>
                                            {{ $deductionPenaltiesSetup->id }}
                                        </td>

                                        <td>
                                            {{ $deductionPenaltiesSetup->employee->employee_manual_id }}
                                        </td>

                                        <td>
                                            {{ $deductionPenaltiesSetup->employee->first_name }}
                                        </td>

                                        <td>
                                            {{ $deductionPenaltiesSetup->additional_deduction_setup->deduction_name  ?? '' }}
                                        </td>

                                        <td>
                                            {{ $deductionPenaltiesSetup->deduction }}
                                        </td>

                                        <td>
                                            {{ $deductionPenaltiesSetup->deduction_date }}
                                        </td>

                                        <td>
                                            @can('additional_deduction_distribution_show')
                                            <a class="btn btn-xs btn-primary" href="{{ route('admin.deduction-penalties.show', $deductionPenaltiesSetup->id) }}">
                                                {{ trans('global.view') }}
                                            </a>
                                            @endcan
                                            @can('additional_deduction_distribution_edit')
                                            <a class="btn btn-xs btn-info" href="{{ route('admin.deduction-penalties.edit', $deductionPenaltiesSetup->id) }}">
                                                {{ trans('global.edit') }}
                                            </a>
                                            @endcan
                                            @can('additional_deduction_distribution_delete')
                                            <form action="{{ route('admin.deduction-penalties.destroy', $deductionPenaltiesSetup->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
                        @if ($deductionPenalties->hasPages())

                            {{ $deductionPenalties->links() }}
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
    @can('additional_deduction_distribution_delete')
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
