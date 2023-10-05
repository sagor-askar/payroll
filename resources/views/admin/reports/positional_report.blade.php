@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 style="color: #605CA8;"><b>Positional Reports</b></h4>
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
                    <h4 style="color: #605CA8;">Positional Information</h4>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>department</th>
                                <th>Rank</th>
                                <th>designation</th>
                                <th>Joining Date</th>
                                <th>Tax</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Sagor Askar</td>
                                <td>Software Development</td>
                                <td>Entry Level</td>
                                <td>Jr. Software Engineer</td>
                                <td>2022-11-01</td>
                                <td>500</td>
                            </tr>    
                        </tbody>
                    </table>
                </div>
                <!-- responsive table div ends -->
            </div>





        </div>
    </div>
</div>
@endsection