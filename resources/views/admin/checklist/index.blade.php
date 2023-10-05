@extends('layouts.admin')
@section('content')
<div class="content">
    @can('branch_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <button type="button" class="btn button" data-toggle="modal" data-target="#exampleModal" style="color: white;">
                    Create Appointment Checklist
                </button>
            </div>
        </div>
    @endcan
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Appointment Checklist List
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-Branch">
                        <thead>
                                <tr>
                                    <th width="10">

                                    </th>
                                    <th>
                                        ID
                                    </th>
                                    <th>
                                        Name
                                    </th>
                                    <th>
                                        &nbsp;Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($checklist as $key => $result)
                                    <tr data-custom_questions='["{{$result->id}}"]' data-id="{{ $result->id}}">
                                        <td>
                                        <input type="hidden" name="checklist_id" id="checklist_id" value="{{ $result->id }} ">
                                        </td>
                                        <td>
                                            {{ $result->id ?? '' }}
                                        </td>
                                        <td>
                                            {{ $result->name ?? '' }}
                                        </td>

                                        <td>
                                            <button class="btn btn-xs btn-primary customQuestion" data-toggle="modal" data-target="#exampleModal2">
                                                {{ trans('global.view') }}
                                            </button>

                                            <button class="open-EditCustom btn btn-xs btn-info" data-id="{{$result->id}}" data-toggle="modal" data-target="#editModal">
                                                {{ trans('global.edit') }}
                                            </button>

                                            <form action="{{ route('admin.checklist.destroy', $result->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                            </form>

                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        @if ($checklist->hasPages())

                            {{ $checklist->links() }}
                        @endif
                    </div>
                </div>
            </div>

            <!-- Custom Question Insert Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Create Appointment Checklist</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" style="margin-top: -30px;">

                            <div class="panel-body">
                                <form method="POST" action="{{ route("admin.checklist.store") }}" enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-12">
                                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                        <label for="name">Name</label>
                                        <input class="form-control" type="text" name="name" id="name" placeholder="Create Checklist Name">
                                        @if($errors->has('name'))
                                            <span class="help-block" role="alert"></span>
                                        @endif
                                        <span class="help-block"></span>
                                    </div>
                                </div>

                                <div class="form-group">

                                    <div class="col-md-6">
                                        <button class="button" type="submit">
                                            {{ trans('global.save') }}
                                        </button>
                                    </div>

                                </div>

                                </form>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal ends -->

            <!-- Custom Question View Modal -->
            <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Details of Checklist
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <div class="form-group">
                                    <a class="btn btn-default" href="{{ route('admin.checklist.index') }}">
                                        {{ trans('global.back_to_list') }}
                                    </a>
                                </div>
                                <table id="showCustomQuestion" class="table table-bordered table-striped ">
                                    <tbody>
                                        <tr>
                                            <th>
                                                Name
                                            </th>
                                            <td id="showQuestion">

                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="form-group">
                                    <a class="btn btn-default" href="{{ route('admin.custom-questions.index') }}">
                                        {{ trans('global.back_to_list') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                    </div>
                </div>
            </div>
            <!-- Modal ends -->

            <!-- Custom Question Edit Modal -->
            <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Edit Appointment Checklist
                        </div>
                        <div class="panel-body">
                            <form method="POST" action="{{ route("admin.checklist.update",1) }}" enctype="multipart/form-data">
                                @method('PUT')
                                @csrf

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                            <label class="required" for="name">Name</label>
                                            <input class="form-control" type="text" name="name" id="name"required>
                                            @if($errors->has('name'))
                                                <span class="help-block" role="alert">{{ $errors->first('name') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div>
                                        <input  type="hidden" name="checklist_id" id="question">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button class="button" type="submit">
                                        {{ trans('global.save') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                    </div>
                </div>
            </div>
            <!-- Modal ends -->



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

<script>
$(document).ready(function() {

        $('.open-EditCustom').on('click', function() {
            var url = "checklist/"
            var id = $(this).data('id').toString();
            url = url.concat("edit/").concat(id);
            $.get(url, function(data) {
                $("#editModal input[name='checklist_id']").val(data['id']);
                $("#editModal input[name='name']").val(data['name']);
            });
        });


        $('.customQuestion').on( 'click', function () {
            var id = ($(this).closest('tr').find('td #checklist_id').val());
            var url = "checklist/"
            url = url.concat("show/").concat(id);
            $.get(url, function(data) {
                $('#showQuestion').empty();
                var rows = "<tr>"
                            + "<td>" + data.name + "</td>"
                            + "</tr>";
                            $('#showQuestion').append(rows);
            });
         } );

        });

</script>
@endsection
