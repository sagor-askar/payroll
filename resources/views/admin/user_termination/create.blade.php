@extends('layouts.admin')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.create') }} Termination
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route("admin.terminations.store") }}" enctype="multipart/form-data">
                        @csrf

                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="required" for="bonus_name">Termination Reason</label>
                                    <input class="form-control" type="text" name="termination_reason" id="termination_reason" value="">
                                    @if($errors->has('termination_reason'))
                                        <span class="help-block" role="alert"></span>
                                    @endif
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('employee') ? 'has-error' : '' }}">
                                    <label  for="employee_id">{{ trans('cruds.attendance.fields.employee') }}</label>
                                    <select class="form-control select2" name="employee_id" id="employee_id" >
                                        <option value="">Select Employee</option>
                                        @foreach($employees as $id => $entry)
                                            <option value="{{ $entry->id }}" {{ old('employee_id') == $entry->id ? 'selected' : '' }}>{{ $entry->first_name }}( {{ $entry->employee_manual_id }} )</option>
                                        @endforeach
                                    </select>
                                    <!-- @if($errors->has('employee'))
                                        <span class="help-block" role="alert">{{ $errors->first('employee') }}</span>
                                @endif -->
                                    <span class="help-block">{{ trans('cruds.attendance.fields.employee_helper') }}</span>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="required"  for="ot_date">Notice Date</label>
                                    <input class="form-control date" placeholder="Pick Your Date" type="text" name="notice_date" id="notice_date" value="">
                                    <span class="help-block" role="alert">{{ $errors->first('notice_date') }}</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="required"  for="ot_date">Termination Date</label>
                                    <input class="form-control date" placeholder="Pick Your Date" type="text" name="terminatation_date" id="terminatation_date" value="">
                                    <span class="help-block" role="alert">{{ $errors->first('terminatation_date') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class=" panel panel-default col-md-11" style="margin-left: 40px;">
                            <div class="form-group {{ $errors->has('details') ? 'has-error' : '' }}">
                                <label for="job_description">Termination Description</label>
                                <textarea class="form-control" name="details" id="descriptionstyle" cols="45" rows="5"></textarea>
                                @if($errors->has('details'))
                                    <span class="help-block" role="alert">{{ $errors->first('details') }}</span>
                                @endif
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
    <script>
        ClassicEditor
            .create(document.querySelector('#descriptionstyle'))
            .catch(error =>{
                console.log(error);
            });
    </script>
@endsection
