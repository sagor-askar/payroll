<!-- demo design -->
<div class="col-md-12">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="required" for="bonus_name">Termination Reason</label>
                                <input class="form-control" type="text" name="bonus_name" id="bonus_name" value="" required>
                                @if($errors->has('bonus_name'))
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
                                    
                                        <option value=""></option>
                                    
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
                                <input class="form-control date" placeholder="Pick Your Date" type="text" name="date" id="date" value="" required>
                                <span class="help-block" role="alert">{{ $errors->first('from_holiday') }}</span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="required"  for="ot_date">Termination Date</label>
                                <input class="form-control date" placeholder="Pick Your Date" type="text" name="date" id="date" value="" required>
                                <span class="help-block" role="alert">{{ $errors->first('from_holiday') }}</span>
                            </div>
                        </div>
                    </div>
                    
                        <div class=" panel panel-default col-md-11" style="margin-left: 40px;">
                            <div class="form-group {{ $errors->has('job_description') ? 'has-error' : '' }}">
                                <label for="job_description">Termination Description</label>
                                <textarea class="form-control" name="job_description" id="descriptionstyle" cols="45" rows="5"></textarea>
                                @if($errors->has('job_description'))
                                    <span class="help-block" role="alert">{{ $errors->first('job_description') }}</span>
                                @endif
                            </div>
                        </div>
                    
<!-- script for description box -->
<script>
        ClassicEditor
            .create(document.querySelector('#descriptionstyle'))
            .catch(error =>{
                console.log(error);
            });
    </script>