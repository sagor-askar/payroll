@extends('layouts.admin')
@section('content')
<div class="content">

    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
                <a class="buttonNew" href="{{ route('admin.interview.create') }}" style="color:white;">Add Interview Details</a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Interview Evaluation List
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-Holiday">
                            <thead>
                                <tr>
                                    <th width="10">

                                    </th>

                                    <th>
                                        ID
                                    </th>
                                    <th>
                                        Candidate Name
                                    </th>
                                    <th>
                                        Job Position
                                    </th>
                                    <th>
                                        Interview Date
                                    </th>
                                    <th>
                                        Total Marks
                                    </th>
                                    <th>
                                        Interviewer
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
                                @foreach($interview_result as $key=>$result)
                                <tr data-entry-id="{{$result->id}}">
                                    <td></td>
                                    <td>
                                        {{ $result->id ?? '' }}
                                    </td>
                                    <td>
                                        {{ $result->candidate->name }}
                                    </td>
                                    <td>
                                        {{ $result->job->job_title }}
                                    </td>
                                    <td>
                                        {{ $result->interview_date }}
                                    </td>
                                    <td>
                                        {{ $result->total_marks }}
                                    </td>
                                    <td>
                                        {{ $result->interviewer }}
                                    </td>

                                    @if($result->status == 0)
                                        <td><strong style="color: #dd4b39"> Not Selected</strong> </td>
                                    @else($result->status == 1)
                                        <td><strong style="color: darkgreen"> Selected</strong> </td>
                                    @endif


                                    <td>
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.interview.show', $result->id) }}">
                                            {{ trans('global.view') }}
                                        </a>

                                        <a class="btn btn-xs btn-info" href="{{ route('admin.interview.edit', $result->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>

                                        <form action="{{ route('admin.interview.destroy', $result->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                        </form>
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if ($interview_result->hasPages())

                            {{ $interview_result->links() }}
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
