@extends('layouts.admin')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Candidate List
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-LeaveApplication">
                            <thead>
                                <tr>
                                    <th width="10">

                                    </th>
                                    <th>
                                      Job Title
                                    </th>
                                    <th>
                                      Name
                                    </th>

                                    <th>
                                        Image
                                    </th>

                                    <th>
                                      Email
                                    </th>
                                    <th>
                                      Phone
                                    </th>

                                    <th>
                                        Apply Date
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
                            @foreach($candidates as $key => $candidate)
                                <tr data-entry-id="{{ $candidate->id }}">
                                    <td>

                                    </td>
                                    <td>
                                        {{ $candidate->job->job_title }}
                                    </td>
                                    <td>
                                        {{ $candidate->name }}
                                    </td>

                                    <td>
                                        <img src="{{url('images/job-application/image/',$candidate->image)}}"  alt="" height="auto" width="70px">
                                    </td>

                                    <td>
                                        {{ $candidate->email }}
                                    </td>
                                    <td>
                                        {{ $candidate->phone }}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($candidate->apply_date)->format('d-m-Y') }}
                                    </td>

                                    @if($candidate->status == 0)
                                        <td><strong style="color: #dd4b39"> Pending</strong> </td>
                                    @elseif($candidate->status == 1)
                                        <td><strong style="color: #ff8902"> Shortlist</strong> </td>
                                    @elseif($candidate->status == 2)
                                        <td><strong style="color: #558000"> Interview</strong> </td>
                                     @elseif($candidate->status == 3)
                                            <td><strong style="color: green"> Selected</strong> </td>
                                        @else
                                        <td><strong style="color: red"> Rejected</strong> </td>
                                    @endif

                                    <td>

                                            <a class="btn btn-xs btn-primary" href="{{ route('admin.candidate.show', $candidate->id) }}">
                                                {{ trans('global.view') }}
                                            </a>

                                            <form action="{{ route('admin.candidate.destroy', $candidate->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                            </form>
                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @if ($candidates->hasPages())

                            {{ $candidates->links() }}
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

  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.leave-applications.massDestroy') }}",
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
