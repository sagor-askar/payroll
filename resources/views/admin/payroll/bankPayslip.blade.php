@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading" style="height: 53px;">
                    Monthly Salary Chart of <b> {{ $monthName }} </b>
                    <a style="float: right" type="button" class="btn btn-primary" href="{{ route('admin.payroll.bankPayslip-pdf', $date) }}" target="_blank">Print Information <i class="fa fa-print" title="Print From Here"></i></a><hr>
                </div>

                <div class="panel-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-Branch">
                            <thead>
                                <tr> 
                                    <th width="10">

                                    </th>
                                    <th>
                                        Employee Name
                                    </th>
                                    <th>
                                        Bank Info
                                    </th>
                                    <th>
                                        Account Number
                                    </th>
                                    <th>
                                        Net Salary
                                    </th>
                                    <th>
                                        Salary Month
                                    </th>
                                    
                                    
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($salaryChart as $key => $chart)

                                    <tr data-entry-id="{{ $chart->id }}">
                                        
                                        <td></td>
                                        <td>
                                            {{ $chart->employee->first_name.' '.$chart->employee->last_name }}
                                        </td>
                                        
                                        <td>
                                            <b>Bank Name:</b>{{ $chart->employee->bank_name }} <br>
                                            <b>Branch Name:</b>{{ $chart->employee->branch_name }} <br>
                                            <b>Account Holder Name:</b>{{ $chart->employee->account_holder_name }}
                                        </td>
                                        <td>
                                            {{ $chart->employee->account_number }}
                                        </td>
                                       
                                        <td>
                                            {{ $chart->net_salary }}
                                        </td>
                                        <td>
                                            {{ $monthName }}
                                        </td>
                                        
                                       
                                        
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                       
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
