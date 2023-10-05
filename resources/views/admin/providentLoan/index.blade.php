@extends('layouts.admin')
@section('content')
<div class="content">
    @can('loan_access_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">

                <a class="buttonNew" href="{{ route('admin.provident_loan.create') }}" style="color:white;">Create Provident Loan</a>

        </div>
    </div>
    @endcan

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                  Provident Loan Application List
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-lateConsideration">
                            <thead>
                                <tr>
                                    <th width="10">

                                    </th>
                                    <th>
                                        Name
                                    </th>
                                    <th>
                                      Loan Amount
                                    </th>
                                    <th>
                                        Installment Amount
                                    </th>
                                    <th>
                                        Paid Amount
                                    </th>

                                    <th>
                                        Due Amount
                                    </th>
                                    <th>
                                        Apply Date
                                    </th>
                                    <th>
                                        Approved Date
                                    </th>
                                    <th>
                                        Approved By
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

                            @foreach($provident_loans as $key=> $value)
                                    <tr data-entry-id="{{$value->id}}">
                                        <td>

                                        </td>
                                        <td>
                                           {{$value->employee->first_name.' '.$value->employee->last_name}}
                                        </td>
                                        <td>
                                            {{$value->amount}}
                                        </td>
                                        <td>
                                            {{$value->installment_amount}}
                                        </td>

                                        <td>
                                            {{$value->paid_amount}}
                                        </td>

                                        <td>
                                            {{$value->due_amount  }}
                                        </td>

                                        <td>
                                            {{$value->apply_date}}
                                        </td>

                                        <td>
                                            {{$value->approved_date ?? ''}}
                                        </td>
                                        <td>
                                            {{$value->permitted_employee->name ?? ' ' }}

                                        </td>



                                        @if($value->status == 0)
                                            <td><strong style="color: #dd4b39"> Pending</strong> </td>
                                        @elseif($value->status == 1)
                                            <td><strong style="color: darkgreen"> Approved</strong> </td>
                                        @else
                                            <td><strong style="color: red"> Rejected</strong> </td>
                                        @endif
                                        <td>
                                            @can('loan_access_show')
                                                @if($value->status != 2)
                                                <a class="btn btn-xs btn-primary" href="{{ route('admin.provident_loan.show', $value->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                                @endif
                                            @endcan
                                            @can('loan_access_edit')
                                                @if($value->status == 0)
                                                <a class="btn btn-xs btn-info" href="{{ route('admin.provident_loan.edit', $value->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                                @endif
                                            @endcan
                                            @if ($value->status != 1)
                                                @can('loan_access_delete')
                                                    <form action="{{ route('admin.provident_loan.destroy', $value->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                                    </form>
                                                @endcan
                                            @endif




                                        </td>
                                    </tr>
                            @endforeach

                            </tbody>
                        </table>
                        @if ($provident_loans->hasPages())

                            {{ $provident_loans->links() }}
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
    @can('loan_access_delete')
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
    //order: [[ '1', 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-lateConsideration:not(.ajaxTable)').DataTable({ buttons: dtButtons})
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
