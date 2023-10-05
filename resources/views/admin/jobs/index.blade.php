@extends('layouts.admin')
@section('content')
<div class="content">
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="buttonNew" href="{{ route('admin.jobs.create') }}" style="color: white;">Add Jobs</a>
            </div>
        </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Job List
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-LeaveApplication">
                            <thead>
                                <tr>
                                    <th width="10">

                                    </th>
                                    <th>
                                        ID
                                    </th>
                                    <th>
                                        Deadline
                                    </th>

                                    <th>
                                       Title
                                    </th>
                                    <th>
                                       Department
                                    </th>
                                    <th>
                                       No of Position
                                    </th>
                                    <th>
                                        Salary Range
                                    </th>
                                    <th>
                                        Circulated Status
                                    </th>
                                    <th>
                                       Approve Status
                                    </th>
                                    <th>
                                        &nbsp;Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($jobs as $key => $job)
                                <tr data-entry-id="{{ $job->id }}">
                                    <td>

                                    </td>
                                    <td>
                                        {{ $job->id ?? '' }}
                                    </td>
                                    <td>
                                        {{ $job->end_date ?? '' }}
                                    </td>
                                    <td>
                                        {{ $job->job_title ?? '' }}
                                    </td>
                                    <td>
                                        {{ $job->department->department_name ?? '' }}
                                    </td>
                                    <td>
                                        {{ $job->no_of_positions ?? '' }}
                                    </td>
                                    <td>
                                        {{ $job->salary_range ?? '' }}
                                    </td>

                                    @if($job->circulate_status==0)
                                    <td style="color: red">Inactive </td>
                                    @else
                                        <td style="color: green">Active </td>
                                    @endif

                                    @if($job->approve_status==0)
                                        <td style="color: orangered">Pending </td>
                                    @elseif($job->approve_status==1)
                                        <td style="color: green">Approved </td>
                                    @else
                                        <td style="color: red">Rejected </td>
                                    @endif

                                    <td>
                                        @if($job->approve_status==1 && $job->circulate_status == 1)
                                            <a class="btn btn-xs btn-success" href="{{ route('admin.jobs.apply', $job->id) }}">
                                               Apply
                                            </a>
                                        @endif



                                        @if($job->approve_status==1)
                                            @if($job->circulate_status==0)

                                        <a class="btn btn-xs btn-success" href="{{ route('admin.jobs.circularActive', $job->id) }}">
                                            Circular Active
                                        </a>
                                            @else
                                                <a class="btn btn-xs btn-warning" href="{{ route('admin.jobs.circularInActive', $job->id) }}">
                                                    Circular Inactive
                                                </a>
                                            @endif
                                        @endif
                                            <a class="btn btn-xs btn-primary" href="{{ route('admin.jobs.show', $job->id) }}">
                                                {{ trans('global.view') }}
                                            </a>
                                            <a class="btn btn-xs btn-info" href="{{ route('admin.jobs.edit', $job->id) }}">
                                                {{ trans('global.edit') }}
                                            </a>
                                            <form action="{{ route('admin.jobs.destroy', $job->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                            </form>


                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @if ($jobs->hasPages())

                            {{ $jobs->links() }}
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
