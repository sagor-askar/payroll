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
                    <form action="{{ route("admin.conveyance.store") }}" method="POST" enctype="multiple/form-data">
                        @csrf

                    <div class="row">
                        @if($role_title == 'Employee')
                            <div class="col-md-3 col-sm-3">
                                <div class=" {{ $errors->has('employee') ? 'has-error' : '' }}">
                                    <label for="employee_id">Employee Name</label>
                                    
                                    <input class="form-control" type="hidden" name="employee_id" value="{{$employees->id}}">
                                    <input readonly class="form-control type="text" value="{{$employees->first_name.' '.$employees->last_name}}">
                                    @if($errors->has('employee'))
                                        <span class="help-block" role="alert">{{ $errors->first('employee') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.attendance.fields.employee_helper') }}</span>
                                </div>          
                            </div>

                            <div class="col-md-3 col-sm-3">
                                <div class="form-group {{ $errors->has('department') ? 'has-error' : '' }}">
                                    <label for="department_id">Departments</label>
                                    <input class="form-control" type="hidden" name="department_id" value="{{$departments->id}}">
                                    <input readonly class="form-control type="text" value="{{$departments->department_name}}">
                                    @if($errors->has('department'))
                                        <span class="help-block" role="alert">{{ $errors->first('department') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.leaveApplication.fields.department_helper') }}</span>
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-3">
                                <div class="form-group {{ $errors->has('designation') ? 'has-error' : '' }}">
                                    <label  for="designation_id">{{ trans('cruds.employee.fields.designation') }}</label>
                                    <input class="form-control" type="hidden" name="designation_id" value="{{$designations->id}}">
                                    <input readonly class="form-control type="text" value="{{$designations->designation_name}}">
                                    @if($errors->has('designation'))
                                        <span class="help-block" role="alert">{{ $errors->first('designation') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.employee.fields.designation_helper') }}</span>
                                </div>
                            </div>
                        @else 

                        <div class="col-md-3 col-sm-3">
                            <div class="form-group {{ $errors->has('department') ? 'has-error' : '' }}">
                                <label for="department_id">Departments</label>
                                <select class="form-control select2" id="department_id" name="department_id">
                                    <option value="">Select Department</option>
                                    @foreach($departments as $id => $entry)
                                        <option value="{{ $entry->id }}" {{ old('department_id') == $entry->id ? : '' }}>{{ $entry->department_name }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('department'))
                                    <span class="help-block" role="alert">{{ $errors->first('department') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.leaveApplication.fields.department_helper') }}</span>
                            </div>
                        </div>
                            

                        <div class="col-md-3 col-sm-3">
                            <div class=" {{ $errors->has('employee') ? 'has-error' : '' }}">
                                <label for="employee_id">Employee Name</label>
                                <select class="form-control select2" name="employee_id" id="employee_id">
                                    <option value="">Select Employee</option>
                                    @foreach($employees as $id => $entry)
                                        <option value="{{ $entry->id }}" {{ old('employee_id') == $entry->id ? 'selected' : '' }}>{{ $entry->first_name }} ({{ $entry->employee_manual_id }})</option>
                                    @endforeach
                                </select>
                                @if($errors->has('employee'))
                                    <span class="help-block" role="alert">{{ $errors->first('employee') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.attendance.fields.employee_helper') }}</span>
                            </div> 
                        </div>

                        <div class="col-md-3 col-sm-3">
                                <div class="form-group {{ $errors->has('designation') ? 'has-error' : '' }}">
                                    <label  for="designation_id">{{ trans('cruds.employee.fields.designation') }}</label>
                                    <select class="form-control select3" name="designation_id" id="designation_id" >
                                        <option value="">Select One</option>
                                        @foreach($designations as $id => $entry)
                                            <option value="{{ $entry->id }}" {{ old('designation_id') == $entry->id ? : '' }}>
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
                            
                        @endif
                            
                            <div class="col-md-3 col-sm-3">
                                    <label for="">Date</label>
                                    <input class="form-control date" placeholder=" Date" type="text" name="conveyance_date" id="conveyance_date" value="{{ old('conveyance_date') }}">
                                    <span class="help-block" role="alert">{{ $errors->first('conveyance_date') }}</span>
                                </div>

                            
                            <!-- table -->
                            <div style="margin: auto;">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-11">
                                            <div class="card rounded-0 border-0 shadow">
                                                <div class="card-body">
                                                        
                                                    <!--  Bootstrap table-->
                                                    <div class="table-responsive">
                                                        <table class="table">
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
                                                                <tr>
                                                                    <th scope="row">1</th>
                                                                    <td>
                                                                        <input type="text" class="form-control" name="description[]" placeholder="Description">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control" name="from_place[]" placeholder="From">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control" name="to_place[]" placeholder="To">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control" name="mode_of_transport[]" placeholder="Transportation Mode">
                                                                    </td>
                                                                    <td>
                                                                        <input type="number"  class="form-control" name="cost[]" value="0">
                                                                    </td>

                                                                    <td>
                                                                        <button class="btn btn-primary" id="insertRow" style="float: right;"><i class="fa fa-plus"></i></button>
                                                                    </td>

                                                                </tr>
                                                            
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                        
                                                </div>
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
        cols += '<td><input class="form-control rounded-0" type="text" name="mode_of_transport[]" placeholder="Transportation Mode"></td>';
        cols += '<td><input class="form-control rounded-0 totalAmount" type="text"  name="cost[]" value="0"></td>';
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
