@extends('layouts.admin')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Add Panel Information Here
                </div>
                <div class="panel-body">
                    <form action="{{ route("admin.panels.store") }}" method="POST" enctype="multiple/form-data">
                        @csrf
                        <div class="row">
                            
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                    <label class="required" for="name">Panel Name</label>
                                    <input class="form-control" type="text" name="name" id="name" value="{{ old('name', '') }}" placeholder="Panel Name" required>
                                    @if($errors->has('name'))
                                        <span class="help-block" role="alert"></span>
                                    @endif
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('employee') ? 'has-error' : '' }}">
                                    <label class="required" for="employee_id">Add Members</label>
                                    <select class="form-control select2 selectpicker" multiple data-live-search="true" name="members[]" id="employee_id" required>
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
<script type="text/javascript">
    $(document).ready(function() {
        $('select').selectpicker();
    });
</script>
@parent

@endsection
