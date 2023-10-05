@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 style="color: #605CA8;"><b>Demographical Reports</b></h4>
                </div>

                <div class="panel-body">
                    <form method="POST" action="{{ route("admin.attendances.store") }}" enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-6 col-ms-3">
                            <div class="form-group {{ $errors->has('employee') ? 'has-error' : '' }}">
                                <label class="required" for="employee_id">{{ trans('cruds.attendance.fields.employee') }}</label>
                                <select class="form-control select2" name="employee_id" id="employee_id" required>
                                    @foreach($employees as $id => $entry)
                                        <option value="{{ $id }}" {{ old('employee_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('employee'))
                                    <span class="help-block" role="alert">{{ $errors->first('employee') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.attendance.fields.employee_helper') }}</span>
                            </div>
                        </div>

                        <div class="col-md-12 col-ms-3">   
                            <button class="button" type="submit">
                                Search
                            </button>    
                        </div>    
                    </form>
                </div>
            </div>

            <!-- print and pdf button -->
            <div class="text-right">
                <button type="button" class="btn btn-warning" id="" onclick="" autocomplete="">
                    <i class="fa fa-print" title="Print From Here"></i>
                </button>
                <button type="button" class="btn btn-warning" id="" onclick="" autocomplete="">
                    <i class="fa fa-file-pdf-o" title="Make a PDF From Here"></i>
                </button>
            </div>
            <br>

            <!-- lower table -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 style="color: #605CA8;">Demographical Information</h4>
                </div>


                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Father Name</th>
                                <th>Mother Name</th>
                                <th>Address</th>
                                <th>Email</th>
                                <th>Contact No</th>
                                <th>Marital Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Sagor</td>
                                <td>Askar</td>
                                <td>Mr. X</td>
                                <td>Mrs. Y</td>
                                <td>Mohammadpur, Dhaka</td>
                                <td>sagor@gmail.com</td>
                                <td>987654321</td>
                                <td>No</td>
                            </tr>    
                        </tbody>
                    </table>
                </div>
                

            </div>





        </div>
    </div>
</div>
@endsection