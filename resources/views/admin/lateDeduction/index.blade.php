@extends('layouts.admin')
@section('content')
<div class="content">
    @can('additional_allowance_setup_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">

                <a class="buttonNew" href="{{ route('admin.late-deduction.create') }}" style="color:white;">Add Late Deduction</a>

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
                                        Company
                                    </td>
                                    <th>
                                        Sub-Company
                                    </th>
                                    <th>
                                        Allowance Name
                                    </th>
                                    <th>
                                        Late Count Days
                                    </th>
                                    <th>
                                        Salary Deducted For
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
                            @foreach($lateDeductionRules as $key => $late_rule)
                                    <tr data-entry-id="{{ $late_rule->id }}">
                                        <td>

                                        </td>
                                        <td>
                                            {{ $late_rule->id ?? '' }}
                                        </td>
                                        <td>
                                            {{ $late_rule->company->comp_name ?? ''}}
                                        </td>
                                        <td>
                                            {{ $late_rule->sub_company->sub_company_name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $late_rule->salary_allowance->allowance_name ?? '' }}
                                        </td>

                                        <td>
                                            {{ $late_rule->late_days ?? ''}}
                                        </td>

                                        <td>
                                            {{ $late_rule->deduction_days ?? '' }}
                                        </td>

                                            @if($late_rule->status == 0)
                                            <td><strong style="color: #dd4b39"> Inactive</strong> </td>
                                            @else
                                            <td><strong style="color: darkgreen"> Active</strong> </td>
                                            @endif
                                          <td>

                                                <a class="btn btn-xs btn-primary" href="{{ route('admin.late-deduction.show', $late_rule->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>

                                                <a class="btn btn-xs btn-info" href="{{ route('admin.late-deduction.edit', $late_rule->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>

                                                <form action="{{ route('admin.late-deduction.destroy', $late_rule->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                                </form>

                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        @if ($lateDeductionRules->hasPages())

                            {{ $lateDeductionRules->links() }}
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
    @can('additional_allowance_setup_delete')
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
