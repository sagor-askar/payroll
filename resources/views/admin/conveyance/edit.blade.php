
@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Create Conveyance List
                </div>
                <div class="panel-body">
                    <form action="{{ route('admin.conveyance.update', [$conveyances->id]) }}" method="POST" enctype="multiple/form-data">
                        @method('PUT')
                        @csrf

                        <h3 style="text-align: center;">Conveyance Bill</h3>
                        <div class="row">
                            @if($role_title == 'Employee')

                                <div class="col-md-3 col-sm-3">
                                    <div class="form-group {{ $errors->has('employee') ? 'has-error' : '' }}">
                                        <label for="employee_id">Employee Name</label>
                                        <select class="form-control select2" name="employee_id" id="employee_id">
                                            <option value="">Select One</option>
                                            @foreach($employees as $key => $employee)
                                                <option value="{{ $employee->id }}" {{ (old('employee_id') ? old('employee_id') : $conveyances->employee->id ?? '') == $employee->id ? 'selected' : '' }}>{{ $employee->first_name }} ({{$employee->employee_manual_id}})</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('employee'))
                                            <span class="help-block" role="alert">{{ $errors->first('employee') }}</span>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.attendance.fields.employee_helper') }}</span>
                                    </div>         
                                </div>

                                <div class="col-md-3 col-sm-3">
                                    <div class="form-group {{ $errors->has('department') ? 'has-error' : '' }}">
                                        <label class="required" for="department_id">{{ trans('cruds.leaveApplication.fields.department') }}</label>
                                        <select class="form-control select2" name="department_id" id="department_id" required>
                                            <option value="">Select One</option>
                                            @foreach($departments as $key => $value)
                                                <option value="{{ $value->id }}" {{ (old('department_id') ? old('department_id') : $conveyances->department->id ?? '') == $value->id ? 'selected' : '' }}>{{ $value->department_name }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('department'))
                                            <span class="help-block" role="alert">{{ $errors->first('department') }}</span>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.leaveApplication.fields.department_helper') }}</span>
                                    </div>
                                </div>
                            @else
                            
                                <div class="col-md-3 col-sm-3">
                                    <div class="form-group {{ $errors->has('department') ? 'has-error' : '' }}">
                                        <label class="required" for="department_id">{{ trans('cruds.leaveApplication.fields.department') }}</label>
                                        <select class="form-control select2" name="department_id" id="department_id" required>
                                            <option value="">Select One</option>
                                            @foreach($departments as $key => $value)
                                                <option value="{{ $value->id }}" {{ (old('department_id') ? old('department_id') : $conveyances->department->id ?? '') == $value->id ? 'selected' : '' }}>{{ $value->department_name }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('department'))
                                            <span class="help-block" role="alert">{{ $errors->first('department') }}</span>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.leaveApplication.fields.department_helper') }}</span>
                                    </div>
                                </div>
                            @endif
                            
                            <div class="col-md-3 col-sm-3">
                                <div class="form-group {{ $errors->has('designation') ? 'has-error' : '' }}">
                                    <label  for="designation_id">{{ trans('cruds.employee.fields.designation') }}</label>
                                    <select class="form-control select3" name="designation_id" id="designation_id">
                                        <option value="">Select One</option>
                                        @foreach($designations as $id => $entry)
                                        <option value="{{ $entry->id }}" {{ (old('designation_id') ? old('designation_id') : $conveyances->designation->id ?? '') == $entry->id ? 'selected' : '' }}>{{ $entry->designation_name }}</option>
                                                {{ $entry->designation_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('designation'))
                                        <span class="help-block" role="alert">{{ $errors->first('designation') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.employee.fields.designation_helper') }}</span>
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-3">
                                <label for="">Date</label>
                                <input class="form-control date" placeholder="Date" type="text" name="conveyance_date" id="conveyance_date" value="{{ old('conveyance_date', \Carbon\Carbon::parse($conveyances->conveyance_date)->format('d-m-Y') ) }}">
                                <span class="help-block" role="alert">{{ $errors->first('conveyance_date') }}</span>
                            </div>
                            
                            <!-- table -->
                            
                            
                            <div class="row">
                                <div class="col-md-12">
                                    
                                            <!--  Bootstrap table-->
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped table-hover datatable datatable-lateConsideration">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">#</th>
                                                            <th scope="col">Description</th>
                                                            <th scope="col">From</th>
                                                            <th scope="col">To</th>
                                                            <th scope="col">Mode of Transport</th>
                                                            <th scope="col">Taka</th>
                                                            <th scope="col"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($conveyanceItems as $key=>$conv_item)
                                                        <tr>
                                                            <th scope="row">{{ $key+1 }}</th>
                                                            <td>
                                                                <input type="text" class="form-control" name="description[]" value="{{$conv_item->description}}">
                                                            </td>

                                                            <td>
                                                                <input type="text" class="form-control" name="from_place[]" value="{{$conv_item->from_place}}">
                                                            </td>

                                                            <td>
                                                                <input type="text" class="form-control" name="to_place[]" value="{{$conv_item->to_place}}">
                                                            </td>

                                                            <td>
                                                                <input type="text" class="form-control" name="mode_of_transport[]" value="{{$conv_item->mode_of_transport}}">
                                                            </td>

                                                            <td>
                                                                <input type="number" class="form-control" name="cost[]" value="{{$conv_item->cost}}">
                                                            </td>
                                                        @endforeach
                                                            <td>
                                                                <button class="btn btn-primary" id="insertRow" style="float: right;"><i class="fa fa-plus"></i></button>
                                                            </td>

                                                        </tr>
                                                    
                                                    </tbody>
                                                </table>
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
        cols += '<td><input class="form-control rounded-0" type="text" name="description[]" placeholder="Description"></td>';
        cols += '<td><input class="form-control rounded-0" type="text" name="from_place[]" placeholder="From"></td>';
        cols += '<td><input class="form-control rounded-0" type="text" name="to_place[]" placeholder="To"></td>';
        cols += '<td><input class="form-control rounded-0" type="text" name="mode_of_transport[]" placeholder="Transport"></td>';
        cols += '<td><input class="form-control rounded-0" type="text" name="cost[]" placeholder="0.00"></td>';
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

<style>
    @media screen and (max-width: 480px) {
        .table-responsive td, th {
            width: 150px;
        }
    }
    @media screen and (max-width: 1500px) {
        .table-responsive {
            width: 94%;
            margin-left: 2%;
            
            margin-bottom: 15px;
            overflow: hidden;
        }
    }
</style>