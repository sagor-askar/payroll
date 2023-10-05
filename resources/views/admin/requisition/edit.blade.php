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
                    <form action="{{ route("admin.requisition.update", [$requisitions->id]) }}" method="POST" enctype="multiple/form-data">
                        @method('PUT')
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('department') ? 'has-error' : '' }}">
                                    <label class="required" for="department_id">{{ trans('cruds.leaveApplication.fields.department') }}</label>
                                    <select class="form-control select2" name="department_id" id="department_id" required>
                                        <option value="">Select One</option>
                                        @foreach($departments as $key => $value)
                                            <option value="{{ $value->id }}" {{ (old('department_id') ? old('department_id') : $requisitions->department->id ?? '') == $value->id ? 'selected' : '' }}>{{ $value->department_name }}</option>
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
                                        @foreach($employees as $key => $employee)
                                            <option value="{{ $employee->id }}" {{ (old('employee_id') ? old('employee_id') : $requisitions->employee->id ?? '') == $employee->id ? 'selected' : '' }}>{{ $employee->first_name }} ({{$employee->employee_manual_id}})</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('employee'))
                                        <span class="help-block" role="alert">{{ $errors->first('employee') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.attendance.fields.employee_helper') }}</span>
                                </div>

                                <div class="form-group">
                                    <label for="">Expected time to have the goods starts</label>
                                    <input class="form-control date" placeholder="Pick Your Date" type="text" name="start_date" id="start_date" value="{{ old('start_date', \Carbon\Carbon::parse($requisitions->start_date)->format('d-m-Y') ) }}">
                                    <span class="help-block" role="alert">{{ $errors->first('start_date') }}</span>
                                </div>

                                <div class="form-group">
                                    <label for="">Expected time to have the goods ends</label>
                                    <input class="form-control date" placeholder="Pick Your Date" type="text" name="end_date" id="end_date" value="{{ old('end_date',\Carbon\Carbon::parse($requisitions->end_date)->format('d-m-Y')) }}">
                                    <span class="help-block" role="alert">{{ $errors->first('end_date') }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Reason For Requesting</label>
                                    <textarea class="form-control" type="text" placeholder="Explain Your Reason" name="reason" id="reason" value=""> {!! $requisitions->reason !!}</textarea>
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
                                                @foreach($requisitionsItems as $key=> $req_item)
                                                <tr>
                                                    <th scope="row">{{$key+1}}</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="name[]" value="{{$req_item->name}}" placeholder=" Item Name">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="description[]" value="{{$req_item->description}}" placeholder="Description">
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control" name="qty[]" value="{{$req_item->qty}}" placeholder="0.00">
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control" name="unit_price[]" value="{{$req_item->unit_price}}" placeholder="0.00">
                                                    </td>
                                                </tr>
                                                @endforeach
                                                <td>
                                                    <button class="btn btn-primary" id="insertRow" style="float: right;"><i class="fa fa-plus"> Add More</i> </button>
                                                </td>

                                                </tbody>
                                            </table>
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
    cols += '<td><input class="form-control rounded-0" type="text" name="description[]" placeholder="Description"></td>';
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
@endsection
