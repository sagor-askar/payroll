@extends('layouts.admin')
@section('content')
<div class="content">

    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="buttonNew" href="{{ route('admin.training.create') }}" style="color: white;">Add Training</a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Training Information List
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-LeaveApplication">
                            <thead>
                                <tr>
                                    <th width="10">

                                    </th>
                                    <th>
                                        Training Type
                                    </th>

                                    <th>
                                        Trainer
                                    </th>
                                    <th>
                                        Training Skill
                                    </th>
                                    <th>
                                        Cost
                                    </th>
                                    <th>
                                        {{ trans('cruds.leaveApplication.fields.start_date') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.leaveApplication.fields.end_date') }}
                                    </th>
                                    <th>
                                        Employees
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
                                @foreach($trainings as $key => $value)
                                @php
                                if($value->employee_id != null)
                                $employee_id = json_decode($value->employee_id);
                                @endphp
                                <tr data-entry-id="{{ $value->id }}">
                                    <td>
                                    <input type="hidden" name="trainingId" id="trainingId" value="{{ $value->id }} ">
                                    </td>
                                    <td>
                                        {{ $value->training_type->name ?? '' }}
                                    </td>

                                    <td>
                                        {{ $value->trainer->name ?? '' }}
                                    </td>


                                    <td>
                                        {{ $value->trainingSkill->name ?? '' }}
                                    </td>

                                    <td>
                                        {{ $value->cost ?? '' }}
                                    </td>
                                    <td>

                                        {{ \Carbon\Carbon::parse($value->start_date)->format('d-m-Y')  ?? '' }}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($value->end_date)->format('d-m-Y')  ?? '' }}
                                    </td>
                                    <td>
                                        @if($value->employee_id == 0)
                                        <b style="color: red;">No Employees!</b>
                                        @else
                                        @if($value->employee_id != null)
                                        <ul> @foreach($employee_id as $key=> $val)
                                            @php
                                            $employee = App\Models\Employee::find($val);
                                            @endphp

                                            <li>{{$employee->first_name .' '.$employee->last_name}}</li>
                                            @endforeach
                                        </ul>
                                        @endif
                                        @endif
                                    </td>
                                    @if($value->status == 0)
                                    <td><strong style="color: #dd4b39"> Pending</strong> </td>
                                    @elseif($value->status == 1)
                                    <td><strong style="color: green"> Approved</strong> </td>
                                    @elseif($value->status == 2)
                                    <td><strong style="color: darkgreen"> Started</strong> </td>
                                    @elseif($value->status == 3)
                                    <td><strong style="color: darkgreen"> Completed</strong> </td>
                                    @else
                                    <td><strong style="color: red"> Terminated</strong> </td>
                                    @endif

                                    <td>
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.training.show', $value->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.training.edit', $value->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                        <form action="{{ route('admin.training.destroy', $value->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                        </form>
                                     

                                        <!-- employee add button -->
                                        @if($value->status == 1)
                                        
                                        <a title="Employees" type="button" class="btn btn-xs btn-info addEmployee" data-toggle="modal" data-target="#exampleModal">
                                            <i class="fa fa-plus"></i>
                                        </a>

                                        <!-- Modal -->

                                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Add Employees under this training </h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form method="POST" action="{{ route("admin.training.employeeStore") }}" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal-body">
                                                            @if($value->employee_id != null)

                                                                @php                
                                                                    $employee_id_list = json_decode($value->employee_id);
                                                                @endphp

                                                                <div>
                                                                    <input type="hidden" id="training_id" name="training_id">
                                                                </div>

                                                                <div class="form-group {{ $errors->has('employee') ? 'has-error' : '' }}">
                                                                    <label class="required" for="employee_id">Add Employees: </label>
                                                                    <select style="width: 20em auto;" class="form-control select2 selectpicker" multiple data-live-search="true" name="employee_id[]" id="employee_id" required>
                                                                        @foreach($employees as $id => $employee)
                                                                        <option value="{{ $employee->id }}" {{ (in_array($employee->id, $employee_id_list)) ? 'selected' : '' }} >{{ $employee->first_name. ' '.$employee->last_name }}({{$employee->employee_manual_id}})</option>
                                                                        @endforeach
                                                                    </select>
                                                                    @if($errors->has('employee'))
                                                                    <span class="help-block" role="alert">{{ $errors->first('employee') }}</span>
                                                                    @endif
                                                                    <span class="help-block">{{ trans('cruds.leaveApplication.fields.employee_helper') }}</span>
                                                                </div>
                                                            
                                                                <div class="col-md-6">
                                                                    <button class="button" type="submit">
                                                                        {{ trans('global.save') }}
                                                                    </button>
                                                                </div>

                                                            @else

                                                                @php                
                                                                    $employee_id_list = json_decode($value->employee_id);
                                                                @endphp

                                                                <div>
                                                                    <input type="hidden" id="training_id" name="training_id">
                                                                </div>

                                                                <div class="form-group {{ $errors->has('employee') ? 'has-error' : '' }}">
                                                                    <label class="required" for="employee_id">Add Members</label>
                                                                    <select style="width: 20em auto;" class="form-control select2 selectpicker" multiple data-live-search="true" name="employee_id[]" id="employee_id" required>
                                                                        <option value="">Select One</option>
                                                                        @foreach($employees as $id => $employee)
                                                                        <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>{{ $employee->first_name. ' '.$employee->last_name }}({{$employee->employee_manual_id}})</option>
                                                                        @endforeach
                                                                    </select>
                                                                    @if($errors->has('employee'))
                                                                    <span class="help-block" role="alert">{{ $errors->first('employee') }}</span>
                                                                    @endif
                                                                    <span class="help-block">{{ trans('cruds.leaveApplication.fields.employee_helper') }}</span>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <button class="button" type="submit">
                                                                        {{ trans('global.save') }}
                                                                    </button>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </form>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        @if ($trainings->hasPages())

                        {{ $trainings->links() }}
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
    $(function() {
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
        let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
        let deleteButton = {
            text: deleteButtonTrans,
            url: "{{ route('admin.training.massDestroy') }}",
            className: 'btn-danger',
            action: function(e, dt, node, config) {
                var ids = $.map(dt.rows({
                    selected: true
                }).nodes(), function(entry) {
                    return $(entry).data('entry-id')
                });

                if (ids.length === 0) {
                    alert('{{ trans('global.datatables.zero_selected ') }}')
                    return
                }

                if (confirm('{{ trans('global.areYouSure ') }}')) {
                    $.ajax({
                            headers: {
                                'x-csrf-token': _token
                            },
                            method: 'POST',
                            url: config.url,
                            data: {
                                ids: ids,
                                _method: 'DELETE'
                            }
                        })
                        .done(function() {
                            location.reload()
                        })
                }
            }
        }
        dtButtons.push(deleteButton)

        $.extend(true, $.fn.dataTable.defaults, {
            orderCellsTop: true,
            order: [
                [1, 'desc']
            ],
            pageLength: 100,
        });
        let table = $('.datatable-LeaveApplication:not(.ajaxTable)').DataTable({
            buttons: dtButtons
        })
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });

    })
</script>

<script>
$(document).ready(function() {

        $('.addEmployee').on('click', function() {
            var id = ($(this).closest('tr').find('td #trainingId').val());
            $("input[name='training_id']").val(id);
        });
     });

</script>


@endsection