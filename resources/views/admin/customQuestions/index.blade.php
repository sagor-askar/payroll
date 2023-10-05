@extends('layouts.admin')
@section('content')
<div class="content">
    @can('branch_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <button type="button" class="btn button" data-toggle="modal" data-target="#exampleModal" style="color: white;">
                    Create Questions
                </button>
            </div>
        </div>
    @endcan
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Custom Question List
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
                                        Question
                                    </th>
                                    <th>
                                        Question Type
                                    </th>
                                    <th>
                                        Condition
                                    </th>
                                    <th>
                                        &nbsp;Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($customQuestion as $key => $custom_questions)
                                    <tr data-custom_questions='["{{$custom_questions->id}}"]' data-id="{{ $custom_questions->id}}">
                                        <td>
                                        <input type="hidden" name="custom_questions_id" id="custom_questions_id" value="{{ $custom_questions->id }} ">
                                        </td>
                                        <td>
                                            {{ $custom_questions->id ?? '' }}
                                        </td>
                                        <td>
                                            {{ $custom_questions->question ?? '' }}
                                        </td>
                                        <td>
                                            {{ $custom_questions->question_type ?? '' }}
                                        </td>

                                        @if($custom_questions->is_required == 1)
                                        <td style="color: green;">
                                            Required
                                        </td>
                                        @else
                                        <td style="color: red;">
                                            Not Required
                                        </td>
                                        @endif

                                        <td>
                                            <button class="btn btn-xs btn-primary customQuestion" data-toggle="modal" data-target="#exampleModal2">
                                                {{ trans('global.view') }}
                                            </button>

                                            <button class="open-EditCustom btn btn-xs btn-info" data-id="{{$custom_questions->id}}" data-toggle="modal" data-target="#editModal">
                                                {{ trans('global.edit') }}
                                            </button>




                                            <form action="{{ route('admin.custom-questions.destroy', $custom_questions->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                            </form>

                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        @if ($customQuestion->hasPages())

                            {{ $customQuestion->links() }}
                        @endif
                    </div>
                </div>
            </div>

            <!-- Custom Question Insert Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Create Custom Questions Here</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" style="margin-top: -30px;">

                            <div class="panel-body">
                                <form method="POST" action="{{ route("admin.custom-questions.store") }}" enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-12">
                                    <div class="form-group {{ $errors->has('question') ? 'has-error' : '' }}">
                                        <label for="question">Question</label>
                                        <input class="form-control" type="text" name="question" id="question" value="" placeholder="Insert Question">
                                        @if($errors->has('question'))
                                            <span class="help-block" role="alert"></span>
                                        @endif
                                        <span class="help-block"></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6">
                                        <div class="form-group {{ $errors->has('question_type') ? 'has-error' : '' }}">
                                            <label class="required" for="question_type">Question Type</label> <br>
                                            <select class="form-control" name="question_type" id="question_type" required>
                                                <option value="">Select One</option>
                                                <option value="interviews">Interviews</option>
                                                <option value="jobs">jobs</option>
                                            </select>

                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group {{ $errors->has('is_required') ? 'has-error' : '' }}">
                                            <label class="required" for="is_required">Condition</label> <br>
                                            <select class="form-control" name="is_required" id="is_required" required>
                                                <option value="">Select One</option>
                                                <option value="1">Required</option>
                                                <option value="0">Not Required</option>
                                            </select>

                                        </div>
                                    </div>

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
                            Details of Questions
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <div class="form-group">
                                    <a class="btn btn-default" href="{{ route('admin.custom-questions.index') }}">
                                        {{ trans('global.back_to_list') }}
                                    </a>
                                </div>
                                <table id="showCustomQuestion" class="table table-bordered table-striped ">
                                    <tbody>
                                        <tr>
                                            <th>
                                                Question
                                            </th>
                                            <td id="showQuestion">

                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Question Type
                                            </th>
                                            <td id="QuestionType">

                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Condition
                                            </th>

                                            <td id="Condition">

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
                            Edit Custom Questions Here
                        </div>
                        <div class="panel-body">
                            <form method="POST" action="{{ route("admin.custom-questions.update",1) }}" enctype="multipart/form-data">
                                @method('PUT')
                                @csrf

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group {{ $errors->has('question') ? 'has-error' : '' }}">
                                            <label class="required" for="question">Question</label>
                                            <input class="form-control" type="text" name="question" id="question"required>
                                            @if($errors->has('question'))
                                                <span class="help-block" role="alert">{{ $errors->first('question') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.leaveType.fields.leave_name_helper') }}</span>
                                        </div>
                                    </div>

                                    <div>
                                        <input  type="hidden" name="custom_id" id="question">
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <div class="form-group" {{ $errors->has('question_type') ? 'has-error' : '' }}">
                                                <label class="required" for="question_type">Question Type</label>
                                                <select class="form-control selectpicker" name="question_type" id="question_type">
                                                    <option selected value="active">Please Select</option>
                                                    <option selected value="interviews">Interviews</option>
                                                    <option selected value="jobs">Jobs</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group" {{ $errors->has('is_required') ? 'has-error' : '' }}">
                                                <label class="required" for="is_required">Question Type</label>
                                                <select class="form-control" name="is_required" id="is_required">
                                                    <option value="active">Please Select</option>
                                                    <option  value="1">Required</option>
                                                    <option value="0">Not Required</option>
                                                </select>
                                            </div>
                                        </div>
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
            var url = "custom-questions/"
            var id = $(this).data('id').toString();
            url = url.concat("edit/").concat(id);
            $.get(url, function(data) {
                $("#editModal input[name='custom_id']").val(data['id']);
                $("#editModal input[name='question']").val(data['question']);
                $("#editModal select[name='question_type']").val(data['question_type']);
                $("#editModal select[name='is_required']").val(data['is_required']);

            });
        });


        $('.customQuestion').on( 'click', function () {
            var id = ($(this).closest('tr').find('td #custom_questions_id').val());
            var url = "custom-questions/"
            url = url.concat("show/").concat(id);
            $.get(url, function(data) {
                $('#showQuestion').empty();
                $('#QuestionType').empty();
                $('#Condition').empty();

                var rows = "<tr>"
                            + "<td>" + data.question + "</td>"
                            + "</tr>";
                            $('#showQuestion').append(rows);
               var question_type = "<tr>"
                            + "<td>" + data.question_type + "</td>"
                            + "</tr>";
                            $('#QuestionType').append(question_type);

               if(data.is_required == 0){
                   $val = "Not required"
                   var condition = "<tr>"
                            + "<td style='color:red'>" + $val + "</td>"
                            + "</tr>";
                            $('#Condition').append(condition);
               }else{
                $val = "Required"
                var condition = "<tr>"
                            + "<td style='color:green'>" + $val + "</td>"
                            + "</tr>";
                            $('#Condition').append(condition);
               }
            });
         } );

        });

</script>
@endsection
