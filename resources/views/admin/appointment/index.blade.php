@extends('layouts.admin')
@section('content')
<div class="content">

    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
                <a class="buttonNew" href="{{ route('admin.appointment.create') }}" style="color:white;">Create Appointment</a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                     Appointment List
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-Holiday">
                            <thead>
                                <tr>
                                    <th width="10">

                                    </th>
                                    <th>
                                        Applicant Name
                                    </th>

                                    <th>
                                        Documents
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
                                @foreach($appointments as $key=>$result)
                                    @php
                                        $appointment_checklist =  json_decode($result->appointment_checklist_id);
                                    @endphp
                                <tr data-entry-id="{{$result->id}}">
                                    <td>

                                    </td>
                                    <td>
                                        {{ $result->interview_result_candidate->candidate->name }}
                                    </td>

                                    <td>
                                        @if(count($appointment_checklist) > 0 )
                                            <ul> @foreach($appointment_checklist as $key=> $val)
                                                    @php
                                                        $appointments_document = \App\Models\AppointmentChecklist::where('id',$val)->first();
                                                    @endphp
                                                    <li>{{$appointments_document->name}}</li>
                                                @endforeach
                                            </ul>

                                        @endif
                                    </td>


                                    @if($result->status == 0)
                                        <td><strong style="color: #dd4b39"> Send</strong> </td>
                                    @else($result->status == 1)
                                        <td><strong style="color: darkgreen"> Confirm</strong> </td>
                                    @endif

                                    <td>
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.appointment.show', $result->id) }}">
                                            {{ trans('global.view') }}
                                        </a>

                                        <a class="btn btn-xs btn-info" href="{{ route('admin.appointment.edit', $result->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>

                                        <form action="{{ route('admin.appointment.destroy', $result->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                        </form>
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if ($appointments->hasPages())

                            {{ $appointments->links() }}
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
@can('holiday_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.holidays.massDestroy') }}",
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
  let table = $('.datatable-Holiday:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
