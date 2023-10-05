@extends('layouts.admin')
@section('content')
<div class="content">

        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                    <a class="buttonNew" href="{{ route('admin.training_skill.create') }}" style="color: white;">Add Training Skill</a>
            </div>
        </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Training Skill {{ trans('global.list') }}
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
                                        {{ trans('cruds.leaveApplication.fields.status') }}
                                    </th>
                                    <th>
                                        &nbsp;Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($training_skills as $key => $value)
                                    <tr data-entry-id="{{ $value->id }}">
                                        <td>

                                        </td>
                                        <td>
                                            {{ $value->name }}
                                        </td>
                                            @if($value->status == 0)
                                            <td><strong style="color:red"> Inactive</strong> </td>
                                            @else
                                            <td><strong style="color: green"> Active</strong> </td>
                                            @endif
                                          <td>

                                              <a class="btn btn-xs btn-warning" href="{{ route('admin.training_skill.changeStatus', $value->id) }}">
                                                  ChangeStatus
                                              </a>

                                              <a class="btn btn-xs btn-primary" href="{{ route('admin.training_skill.show', $value->id) }}">
                                                  {{ trans('global.view') }}
                                              </a>

                                              <a class="btn btn-xs btn-info" href="{{ route('admin.training_skill.edit', $value->id) }}">
                                                  {{ trans('global.edit') }}
                                              </a>

                                            <form action="{{ route('admin.training_skill.destroy', $value->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        @if ($training_skills->hasPages())

                            {{ $training_skills->links() }}
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
    url: "{{ route('admin.training_skill.massDestroy') }}",
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

@endsection
