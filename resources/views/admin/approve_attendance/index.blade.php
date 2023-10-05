@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Waiting For Approval
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-lateConsideration">
                            <thead>
                                <tr>
                                    <th width="10">

                                    </th>
                                    <th>
                                        Emp. ID
                                    </th>
                                    <th>
                                        Employee Name
                                    </th>
                                    <th>
                                        Date
                                    </th>

                                    <th>
                                        Clock In Time
                                    </th>

                                    <th>
                                        Device
                                    </th>
                                    <th>
                                        Location
                                    </th>
                                    
                                    <th>
                                        &nbsp;Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($approve_attendance as $key=>$approval)
                                    <tr data-entry-id="{{$approval->id}}">
                                        <td>

                                        </td>
                                        <td>
                                            {{ $approval->employee_id }}
                                        </td>
                                        <td>
                                            {{$approval->employee->first_name.' '.$approval->employee->last_name}}
                                        </td>
                                        <td>
                                            
                                            {{ $approval->authDate }}
                                        </td>
                                        <td>
                                            {{ $approval->authTime }}
                                        </td>
                                        <td>
                                            {{ $approval->deviceName }} 
                                        </td>
                                        <td>
                                            {{ $approval->location }} 
                                        </td>
                                        
                                        <td>
                                            <a class="btn btn-xs btn-primary" href="{{ route('admin.approveattendance.show', $approval->id) }}">
                                                {{ trans('global.view') }}
                                            </a>
                                            <a class="btn btn-xs btn-info" href="{{ route('admin.approveattendance.approve', $approval->id) }}">
                                                Approve
                                            </a>
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
    let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
    let deleteButton = {
    text: deleteButtonTrans,
    url: "#",
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


  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    //order: [[ '1', 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-lateConsideration:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
