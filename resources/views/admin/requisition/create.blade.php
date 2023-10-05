@extends('layouts.admin')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Requision Form
                </div>
                <div class="panel-body">
                    <form action="{{ route("admin.requisition.store") }}" method="POST" enctype="multiple/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('department') ? 'has-error' : '' }}">
                                    <label class="required" for="department_id">{{ trans('cruds.leaveApplication.fields.department') }}</label>
                                    <select class="form-control select2" name="department_id" id="department_id" required>
                                        <option value="">Select One</option>
                                        @foreach($departments as $key => $value)
                                            <option value="{{ $value->id }}" {{ old('department_id') == $value->id ? 'selected' : '' }}>{{ $value->department_name }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('department'))
                                        <span class="help-block" role="alert">{{ $errors->first('department') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.leaveApplication.fields.department_helper') }}</span>
                                </div>

                                <div class="form-group {{ $errors->has('employee') ? 'has-error' : '' }}">
                                    <label for="employee_id">Requesting Person</label>
                                    <select class="form-control select2" name="employee_id" id="employee_id">
                                        <option value="">Select One</option>
                                        @foreach($employees as $id => $entry)
                                            <option value="{{ $entry->id }}" {{ old('employee_id') == $entry->id ? 'selected' : '' }}>{{ $entry->first_name }} ({{ $entry->employee_manual_id }})</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('employee'))
                                        <span class="help-block" role="alert">{{ $errors->first('employee') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.attendance.fields.employee_helper') }}</span>
                                </div>

                                <div class="form-group">
                                    <label for="">Expected time to have the goods starts</label>
                                    <input class="form-control date" placeholder="Pick Your Date" type="text" name="start_date" id="start_date" value="{{ old('start_date') }}">
                                    <span class="help-block" role="alert">{{ $errors->first('start_date') }}</span>
                                </div>

                                <div class="form-group">
                                    <label for="">Expected time to have the goods ends</label>
                                    <input class="form-control date" placeholder="Pick Your Date" type="text" name="end_date" id="end_date" value="{{ old('end_date') }}">
                                    <span class="help-block" role="alert">{{ $errors->first('end_date') }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Reason For Requesting</label>
                                    <textarea class="form-control" type="text" placeholder="Explain Your Reason" name="reason" id="reason" value=""></textarea>
                                    <span class="help-block">{{ trans('cruds.employee.fields.first_name_helper') }}</span>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-12">
                                <div class="card rounded-0 border-0 shadow">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Name</th>
                                                        <th scope="col">Description</th>
                                                        <th scope="col">Quantity</th>
                                                        <th scope="col">Price</th>
                                                        <th scope="col"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th scope="row">1</th>
                                                        <td>
                                                            <input type="text" class="form-control" name="name[]" placeholder=" Item Name">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" name="description[]" placeholder="Description">
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control" name="qty[]" placeholder="0.00">
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control" name="unit_price[]" placeholder="0.00">
                                                        </td>
                                                        <td>
                                                        <button class="btn btn-primary" id="insertRow" style="float: right;"><i class="fa fa-plus"></i></button>
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- Add rows button-->
                                        <div class="col-md-12">
                                            <!-- <a class="btn btn-primary " id="insertRow" href="#" style="float: right;">Add More</a> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button class="button" type="submit">
                                        {{ trans('global.save') }}
                                    </button>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(function () {

    // Start counting from the third row
    var counter = 2;

    $("#insertRow").on("click", function (event) {
        event.preventDefault();

        var newRow = $("<tr>");
        var cols = '';

    // Table columns
    cols += '<th scrope="row">' + counter + '</th>';
    cols += '<td><input class="form-control rounded-0" type="text" name="name[]" placeholder="Item name"></td>';
    cols += '<td><input class="form-control rounded-0" type="text" name="description[]" placeholder=" Description"></td>';
    cols += '<td><input class="form-control rounded-0" type="text" name="qty[]" placeholder="0.00"></td>';
    cols += '<td><input class="form-control rounded-0" type="text" name="unit_price[]" placeholder="0.00"></td>';
    cols += '<td><button class="btn btn-danger rounded-0" id ="deleteRow"><i class="fa fa-trash"></i></button</td>';

        // Insert the columns inside a row
        newRow.append(cols);

        // Insert the row inside a table
        $("table").append(newRow);

        // Increase counter after each row insertion
        counter++;
    });

        // Remove row when delete btn is clicked
        $("table").on("click", "#deleteRow", function (event) {
            $(this).closest("tr").remove();
            counter -= 1
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $(document).on('change', '#department_id', function () {
            var id = $(this).val();
            $.ajax({
                type: 'get',
                url: '{{ route("admin.get_reporting_employee.employee") }}',
                data: {'id': id},
                dataType: "json",
                success: function (data) {
                    if(data){
                        $('#employee_id').empty();
                        $('#employee_id').focus;
                        $('#employee_id').append('<option value="0" required="" >Select One </option>');
                        $.each(data, function(key, value){
                            $('select[name="employee_id"]').append('<option value="'+ value.id +'">' + value.first_name+' '+ value.last_name +' '+value.employee_manual_id+'</option>');
                        });
                    }else{
                        $('#employee_id').empty();
                    }
                },
                error: function () {

                }
            });
        });
    });
</script>
@endsection
