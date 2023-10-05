@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Edit Panel Information Here
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route("admin.panels.update", [$panels->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                    <label class="required" for="name">Name</label>
                                    <input class="form-control" type="text" name="name" id="name" value="{{ old('name', $panels->name) }}" required>
                                    @if($errors->has('name'))
                                        <span class="help-block" role="alert">{{ $errors->first('name') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.leaveType.fields.leave_name_helper') }}</span>
                                </div>
                               
                                <div class="form-group" {{ $errors->has('status') ? 'has-error' : '' }}">
                                    <label class="required" for="status">Status</label>
                                    <select class="form-control" name="status" id="status">
                                        <option value="active">Please Select</option>
                                        <option  value="1" {{ (old('status') ? old('status') : $panels->status ?? '') == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ (old('status') ? old('status') : $panels->status ?? '') == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select> 
                                </div>
                            </div>
                    
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('employee') ? 'has-error' : '' }}">
                                    <label class="required" for="employee_id">Edit Members</label>
                                    <select class="form-control select2 selectpicker" multiple data-live-search="true" name="members[]" id="employee_id" required>
                                        <option value="">Select One</option>
                                        @foreach($employees as $id => $employee)
                                         <option  value="{{ $employee->id }}" {{ (in_array($employee->id, $members)) ? 'selected' : '' }}>{{ $employee->first_name. ' '.$employee->last_name }}({{$employee->employee_manual_id}})</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('employee'))
                                        <span class="help-block" role="alert">{{ $errors->first('employee') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.leaveApplication.fields.employee_helper') }}</span>
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



        </div>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $('select').selectpicker();
    });
</script>
@parent

@endsection
