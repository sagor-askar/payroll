@extends('layouts.admin')
@section('content')
<div class="content">
    @can('trainer_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">

                    <a class="buttonNew" href="{{ route('admin.trainer.create') }}" style="color: white;">Add Trainer</a>

            </div>
        </div>
    @endcan
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Trainer {{ trans('global.list') }}
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-LeaveApplication">
                            <thead>
                                <tr>
                                    <th width="10">

                                    </th>
                                    <th>
                                       Name
                                    </th>
                                    <th>
                                       Email
                                    </th>
                                    <th>
                                       Contact Number
                                    </th>
                                    <th>
                                       Address
                                    </th>

                                    <th>
                                        Expertise
                                    </th>
                                    <th>
                                        {{ trans('cruds.leaveApplication.fields.status') }}
                                    </th>
                                    <th>
                                        &nbsp;Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($trainers as $key => $value)
                                    <tr data-entry-id="{{ $value->id }}">
                                        <td>

                                        </td>
                                        <td>
                                            {{ $value->name }}
                                        </td>
                                        <td>
                                            {{ $value->email ?? '' }}
                                        </td>
                                        <td>
                                            {{ $value->contact_number }}
                                        </td>
                                        <td>
                                            {{ $value->address }}
                                        </td>
                                        <td>
                                            {{ $value->expertise }}
                                        </td>

                                            @if($value->status == 0)
                                            <td><strong style="color:red"> Inactive</strong> </td>
                                            @else
                                            <td><strong style="color: green"> Active</strong> </td>
                                            @endif
                                          <td>

                                              <a class="btn btn-xs btn-warning" href="{{ route('admin.trainer.changeStatus', $value->id) }}">
                                                  ChangeStatus
                                              </a>

                                              <a class="btn btn-xs btn-primary" href="{{ route('admin.trainer.show', $value->id) }}">
                                                  {{ trans('global.view') }}
                                              </a>

                                              <a class="btn btn-xs btn-info" href="{{ route('admin.trainer.edit', $value->id) }}">
                                                  {{ trans('global.edit') }}
                                              </a>

                                            <form action="{{ route('admin.trainer.destroy', $value->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        @if ($trainers->hasPages())

                            {{ $trainers->links() }}
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
@can('leave_application_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.trainer.massDestroy') }}",
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
  let table = $('.datatable-LeaveApplication:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})
</script>

<script>
    function rejectFunction() {
        if(!confirm("Are You Sure to Reject ?"))
            event.preventDefault();
    }
</script>

<script>
    function approveFunction() {
        if(!confirm("You are going to Approve !"))
            event.preventDefault();
    }
</script>
@endsection
