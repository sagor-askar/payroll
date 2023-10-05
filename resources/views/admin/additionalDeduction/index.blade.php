@extends('layouts.admin')
@section('content')
<div class="content">
    @can('additional_deduction_setup_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">

                <a class="buttonNew" href="{{ route('admin.additional-deduction.create') }}" style="color:white;">Add Additional Deduction</a>

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
                                    <th>
                                        ID
                                    </th>
                                    <th>
                                        Company
                                    </th>
                                    <th>
                                        Sub-Company
                                    </th>
                                    <th>
                                        Deduction Name
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
                                    @foreach($additionalDeduction as $key=>$additionalDeductionSetup)
                                    <tr data-entry-id="">

                                        <td>

                                        </td>
                                        <td>
                                            {{ $additionalDeductionSetup->id }}
                                        </td>
                                        <td>
                                            {{ $additionalDeductionSetup->company->comp_name }}
                                        </td>

                                        <td>
                                            {{ $additionalDeductionSetup->sub_company->sub_company_name }}
                                        </td>

                                        <td>
                                            {{ $additionalDeductionSetup->deduction_name }}
                                        </td>


                                        @if($additionalDeductionSetup->status == 1)
                                        <td style="color: green;">
                                            Active
                                        </td>
                                        @else
                                        <td style="color: red;">
                                            Inactive
                                        </td>
                                        @endif


                                        <td>
                                            @can('additional_deduction_setup_show')
                                            <a class="btn btn-xs btn-primary" href="{{ route('admin.additional-deduction.show', $additionalDeductionSetup->id) }}">
                                                {{ trans('global.view') }}
                                            </a>
                                            @endcan
                                            @can('additional_deduction_setup_edit')
                                            <a class="btn btn-xs btn-info" href="{{ route('admin.additional-deduction.edit', $additionalDeductionSetup->id) }}">
                                                {{ trans('global.edit') }}
                                            </a>
                                            @endcan
                                            @can('additional_deduction_setup_delete')
                                            <form action="{{ route('admin.additional-deduction.destroy', $additionalDeductionSetup->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
                        @if ($additionalDeduction->hasPages())

                            {{ $additionalDeduction->links() }}
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
    @can('additional_deduction_setup_delete')
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
