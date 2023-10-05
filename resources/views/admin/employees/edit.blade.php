@extends('layouts.admin')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.edit') }} {{ trans('cruds.employee.title_singular') }}
                </div>
                <div class="panel-body">
                    <form method="POST" id="basic-form"   action="{{ route("admin.employees.update", [$employee->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div id="example-basic">
                             <!-- Basic Information Form -->
                             <h3>Update Basic Information</h3>
                            <section id="first">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
                                            <label class="required" for="first_name">{{ trans('cruds.employee.fields.first_name') }}</label>
                                            <input class="form-control" type="text" name="first_name" id="first_name" value="{{ old('first_name', $employee->first_name) }}" placeholder="First Name" required>
                                            @if($errors->has('first_name'))
                                                <span class="help-block" role="alert">{{ $errors->first('first_name') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.employee.fields.first_name_helper') }}</span>
                                        </div>

                                        <div class="form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
                                            <label class="required" for="last_name">{{ trans('cruds.employee.fields.last_name') }}</label>
                                            <input class="form-control" type="text" name="last_name" id="last_name" value="{{ old('last_name', $employee->last_name) }}" placeholder="Last Name" required>
                                            @if($errors->has('last_name'))
                                                <span class="help-block" role="alert">{{ $errors->first('last_name') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.employee.fields.last_name_helper') }}</span>
                                        </div>

                                        <div class="form-group {{ $errors->has('father_name') ? 'has-error' : '' }}">
                                            <label class="required" for="father_name">{{ trans('cruds.employee.fields.father_name') }}</label>
                                            <input class="form-control" type="text" name="father_name" id="father_name" value="{{ old('father_name', $employee->father_name) }}" placeholder="Father Name" required>
                                            @if($errors->has('father_name'))
                                                <span class="help-block" role="alert">{{ $errors->first('father_name') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.employee.fields.father_name_helper') }}</span>
                                        </div>

                                        <div class="form-group {{ $errors->has('mother_name') ? 'has-error' : '' }}">
                                            <label class="required" for="mother_name">{{ trans('cruds.employee.fields.mother_name') }}</label>
                                            <input class="form-control" type="text" name="mother_name" id="mother_name" value="{{ old('mother_name', $employee->mother_name) }}" placeholder="Mother Name" required>
                                            @if($errors->has('mother_name'))
                                                <span class="help-block" role="alert">{{ $errors->first('mother_name') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.employee.fields.mother_name_helper') }}</span>
                                        </div>

                                        <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                                            <label  for="address">{{ trans('cruds.employee.fields.address') }}</label>
                                            <input class="form-control" type="text" name="address" id="address" value="{{ old('address', $employee->address) }}" placeholder="Address" >
                                            @if($errors->has('address'))
                                                <span class="help-block" role="alert">{{ $errors->first('address') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.employee.fields.address_helper') }}</span>
                                        </div>

                                        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                                            <label class="required" for="email">{{ trans('cruds.employee.fields.email') }}</label>
                                            <input class="form-control" type="text" name="email" id="emaillogin" value="{{ old('email', $employee->email) }}" placeholder="Your Email" required>
                                            @if($errors->has('email'))
                                                <span class="help-block" role="alert">{{ $errors->first('email') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.employee.fields.email_helper') }}</span>
                                        </div>

                                        <div class="form-group {{ $errors->has('contact_no') ? 'has-error' : '' }}">
                                            <label class="required" for="contact_no">{{ trans('cruds.employee.fields.contact_no') }}</label>
                                            <input class="form-control" type="number" name="contact_no" id="contact_no" value="{{ old('contact_no', $employee->contact_no) }}" placeholder="Your Contact" required>
                                            @if($errors->has('contact_no'))
                                                <span class="help-block" role="alert">{{ $errors->first('contact_no') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.employee.fields.contact_no_helper') }}</span>
                                        </div>


                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group {{ $errors->has('gender') ? 'has-error' : '' }}">
                                            <label>{{ trans('cruds.employee.fields.gender') }}</label>
                                            <select class="form-control" name="gender" id="gender">
                                                <option value disabled {{ old('gender', null) === null ? 'selected' : '' }}>
                                                    Please select your gender
                                                </option>
                                                @foreach(App\Models\Employee::GENDER_SELECT as $key => $label)
                                                    <option value="{{ $key }}" {{ old('gender', $employee->gender) === (string) $key ? 'selected' : '' }}>{{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('gender'))
                                                <span class="help-block" role="alert">{{ $errors->first('gender') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.employee.fields.gender_helper') }}</span>
                                        </div>
                                        <div class="form-group {{ $errors->has('gender') ? 'has-error' : '' }}">
                                            <label>Marital Status</label><br>
                                            <label>
                                                <input class="" type="radio" onclick="spouseDivShow()" name="marital_status" value="1" id="flexRadioDefault2" {{$employee->marital_status == 1 ? 'checked': ' '}}>Yes
                                            </label>
                                            <label>
                                                <input class="" type="radio" onclick="spouseDivHidden()" name="marital_status" value="0" id="flexRadioDefault2" {{$employee->marital_status == 0 ? 'checked': ' '}}>No
                                            </label>
                                        </div>

                                        <div id="myDIV" style="display:none">
                                            <div class="form-group {{ $errors->has('spouse') ? 'has-error' : '' }}">
                                                <label for="contact_no">{{ trans('cruds.employee.fields.spouse') }}</label>
                                                <input class="form-control" type="text" name="spouse" id="spouse" value="{{ old('spouse',  $employee->spouse) }}" placeholder="Your Spouse Name">
                                                @if($errors->has('spouse'))
                                                    <span class="help-block" role="alert">{{ $errors->first('spouse') }}</span>
                                                @endif
                                                <span class="help-block">{{ trans('cruds.employee.fields.contact_no_helper') }}</span>
                                            </div>

                                            <div class="form-group {{ $errors->has('spouse_contact_no') ? 'has-error' : '' }}">
                                                <label for="contact_no">{{ trans('cruds.employee.fields.spouse_contact_no') }}</label>
                                                <input class="form-control" type="number" name="spouse_contact_no" id="spouse_contact_no" value="{{ old('spouse_contact_no', $employee->spouse_contact_no) }}" placeholder="Your Spouse Contact">
                                                @if($errors->has('spouse_contact_no'))
                                                    <span class="help-block" role="alert">{{ $errors->first('spouse_contact_no') }}</span>
                                                @endif
                                                <span class="help-block">{{ trans('cruds.employee.fields.contact_no_helper') }}</span>
                                            </div>
                                        </div>

                                        <div style="margin-top: 6px" class="form-group {{ $errors->has('emergency_contact_no') ? 'has-error' : '' }}">
                                            <label for="emergency_contact_no">{{ trans('cruds.employee.fields.emergency_contact_no') }}</label>
                                            <input class="form-control" type="number" name="emergency_contact_no" id="emergency_contact_no" value="{{ old('emergency_contact_no',  $employee->emergency_contact_no) }}" placeholder="Your Emergency Contact">
                                            @if($errors->has('emergency_contact_no'))
                                                <span class="help-block" role="alert">{{ $errors->first('emergency_contact_no') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.employee.fields.contact_no_helper') }}</span>
                                        </div>

                                        <div class="form-group {{ $errors->has('emergency_address') ? 'has-error' : '' }}">
                                            <label for="emergency_address">{{ trans('cruds.employee.fields.emergency_address') }}</label>
                                            <input class="form-control" type="text" name="emergency_address" id="emergency_address" value="{{ old('emergency_address', $employee->emergency_address) }}" placeholder="Your Emergency Address">
                                            @if($errors->has('emergency_address'))
                                                <span class="help-block" role="alert">{{ $errors->first('emergency_address') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.employee.fields.emergency_address_helper') }}</span>
                                        </div>
                                        <div class="form-group {{ $errors->has('nid_no') ? 'has-error' : '' }}">
                                            <label class="required" for="nid_no">{{ trans('cruds.employee.fields.nid_no') }}</label>
                                            <input class="form-control" type="number" name="nid_no" id="nid_no" value="{{ old('nid_no', $employee->nid_no) }}" placeholder="Your NID" required>
                                            @if($errors->has('nid_no'))
                                                <span class="help-block" role="alert">{{ $errors->first('nid_no') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.employee.fields.nid_no_helper') }}</span>
                                        </div>

                                        <div class="form-group {{ $errors->has('passport_no') ? 'has-error' : '' }}">
                                            <label for="passport_no">{{ trans('cruds.employee.fields.passport_no') }}</label>
                                            <input class="form-control" type="text" name="passport_no" id="passport_no" value="{{ old('passport_no', $employee->passport_no) }}" placeholder="Your Passport No">
                                            @if($errors->has('passport_no'))
                                                <span class="help-block" role="alert">{{ $errors->first('passport_no') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.employee.fields.passport_no_helper') }}</span>
                                        </div>

                                        <div class="form-group {{ $errors->has('blood_group') ? 'has-error' : '' }}">
                                            <label for="blood_group">{{ trans('cruds.employee.fields.blood_group') }}</label>
                                            <input class="form-control" type="text" name="blood_group" id="blood_group" value="{{ old('blood_group', $employee->blood_group) }}" placeholder="Your Blood Group">
                                            @if($errors->has('blood_group'))
                                                <span class="help-block" role="alert">{{ $errors->first('blood_group') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.employee.fields.blood_group_helper') }}</span>
                                        </div>
                                    </div>

                                </div>

                            </section>


                            <!-- Positional Information Form -->
                            <h3>Update Positional Information</h3>
                            <section id="positional_information">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group {{ $errors->has('employee_device_id') ? 'has-error' : '' }}">
                                            <label for="employee_device_id">{{ trans('cruds.employee.fields.employee_device_id') }}</label>
                                            <input class="form-control" type="number" name="employee_device_id" id="employee_device_id" value="{{ old('employee_device_id', $employee->employee_device_id) }}" placeholder="Your Device ID">
                                            @if($errors->has('employee_device_id'))
                                                <span class="help-block" role="alert">{{ $errors->first('employee_device_id') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.employee.fields.employee_device_id_helper') }}</span>
                                        </div>

                                        <div class="form-group {{ $errors->has('sub_company_id') ? 'has-error' : '' }}">
                                            <label class="" for="sub_company_id">Sub Company</label>
                                            <select class="form-control select3" name="sub_company_id"  id="sub_company_id" >
                                                <option value="">Select One</option>
                                                @foreach($sub_companies as $id => $sub_company)
                                                    {{-- <option value="{{ $sub_company->id }}">{{ $sub_company->sub_company_name }}</option> --}}
                                                    <option value="{{ $sub_company->id }}" {{ (old('sub_company_id') ? old('sub_company_id') : $employee->subcompany->id ?? '') == $sub_company->id ? 'selected' : '' }}>{{ $sub_company->sub_company_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group {{ $errors->has('department') ? 'has-error' : '' }}">
                                            <label class="required" for="department_id">{{ trans('cruds.employee.fields.department') }}</label>
                                            <select class="form-control select3" name="department_id" id="department_id" required>
                                                @foreach($departments as $id => $entry)
                                                <option value="{{ $id }}" {{ (old('department_id') ? old('department_id') : $employee->department->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                                    {{-- <option value="{{ $id }}" {{ old('department_id') == $id ? 'selected' : '' }}>
                                                        {{ $entry }}
                                                    </option> --}}
                                                @endforeach
                                            </select>
                                            @if($errors->has('department'))
                                                <span class="help-block" role="alert">{{ $errors->first('department') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.employee.fields.department_helper') }}</span>
                                        </div>

                                        <div class="form-group {{ $errors->has('designation') ? 'has-error' : '' }}">
                                            <label class="required" for="designation_id">{{ trans('cruds.employee.fields.designation') }}</label>
                                            <select class="form-control select3" name="designation_id" id="designation_id" required>
                                                @foreach($designations as $id => $entry)
                                                <option value="{{ $id }}" {{ (old('designation_id') ? old('designation_id') : $employee->designation->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                                    {{-- <option value="{{ $id }}" {{ old('designation_id') == $id ? 'selected' : '' }}>
                                                        {{ $entry }}
                                                    </option> --}}
                                                @endforeach
                                            </select>
                                            @if($errors->has('designation'))
                                                <span class="help-block" role="alert">{{ $errors->first('designation') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.employee.fields.designation_helper') }}</span>
                                        </div>

                                        <div class="form-group {{ $errors->has('employee_assign_to_id') ? 'has-error' : '' }}">
                                            <label class="required" for="employee_assign_to_id">{{ trans('cruds.employee.fields.employee_assign_to_id') }}</label>
                                            <select class="form-control select3" name="employee_assign_to_id" id="employee_assign_to_id" required>
                                                @foreach($employees as $key => $emp)
                                                    <option selected value="{{ $emp->id }}">
                                                        {{ $emp->first_name.' '.$emp->last_name }}
                                                    </option>
                                                @endforeach
                                                {{-- @foreach($employees as $id => $entry)
                                                    <option value="{{ $id }}" {{ old('employee_assign_to_id') == $id ? 'selected' : '' }}>
                                                        {{ $entry }}
                                                    </option>
                                                @endforeach --}}
                                            </select>
                                            @if($errors->has('employee_assign_to_id'))
                                                <span class="help-block" role="alert">{{ $errors->first('employee_assign_to_id') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.employee.fields.employee_assign_to_id_helper') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group {{ $errors->has('grade') ? 'has-error' : '' }}">
                                            <label for="grade_id">{{ trans('cruds.employee.fields.grade') }}</label>
                                            <select class="form-control select3" name="grade_id" id="grade_id">
                                                @foreach($grades as $id => $entry)
                                                <option value="{{ $id }}" {{ (old('grade_id') ? old('grade_id') : $employee->grade->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                                    {{-- <option value="{{ $id }}" {{ old('grade_id') == $id ? 'selected' : '' }}>
                                                        {{ $entry }}
                                                    </option> --}}
                                                @endforeach
                                            </select>
                                            @if($errors->has('grade'))
                                                <span class="help-block" role="alert">{{ $errors->first('grade') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.employee.fields.grade_helper') }}</span>
                                        </div>

                                        <div class="form-group {{ $errors->has('joining_date') ? 'has-error' : '' }}">
                                            <label class="required" for="joining_date">{{ trans('cruds.employee.fields.joining_date') }}</label>
                                            <input class="form-control" type="text" name="joining_date" id="joining_date" value="{{ old('joining_date',$employee->joining_date) }}" placeholder="01-01-2022" required>
                                            @if($errors->has('joining_date'))
                                                <span class="help-block" role="alert">{{ $errors->first('joining_date') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.employee.fields.joining_date_helper') }}</span>
                                        </div>
                                        <div class="form-group">
                                            <label>Is Attendance ?</label><br>
                                            <label for="music">
                                                <input class="form-check-input" type="radio"  name="is_attendence" value="1" id="flexRadioDefault2" {{$employee->is_attendence == 1 ? 'checked': ' '}}>Yes
                                            </label>
                                            <label for="music">
                                                <input class="form-check-input" type="radio" name="is_attendence" value="0" id="flexRadioDefault2" {{$employee->is_attendence == 0 ? 'checked': ' '}}>No
                                            </label>

                                        </div>

                                        <!-- attendance type -->
                                        <div class="form-group">
                                           <label class="required" for="date">Attendance Type</label>
                                            <select class="form-control " name="attendance_type" id="attendance_type">
                                                <option value="Branch" @if($employee->attendance_type == 'Branch') selected @endif >Branch</option>
                                                <option value="Roster" @if($employee->attendance_type == 'Roster') selected @endif >Roster</option>
                                                <option value="Shift"  @if($employee->attendance_type   == 'Shift') selected @endif>Shift</option>
                                            </select>
                                        </div>
                                       @if($employee->attendance_type   == 'Shift' || $employee->shift_id != null )
                                        <div class="form-group showShift">
                                           <label class="required" for="date">Shift</label>
                                            <select class="form-control " name="shift_id" id="shift_id">
                                                <option value="">Select Shift</option>
                                                @foreach($shifts as $id => $shift)
                                                    <option value="{{ $shift->id }}" {{ (old('shift_id') ? old('shift_id') : $employee->shift_id?? '') == $shift->id ? 'selected' : '' }}>{{ $shift->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @else
                                            <div class="form-group showShift" style="display: none">
                                                <label class="required" for="date">Shift</label>
                                                <select class="form-control " name="shift_id" id="shift_id">
                                                    <option value="">Select Shift</option>
                                                    @foreach($shifts as $id => $shift)
                                                        <option value="{{ $shift->id }}" {{ (old('shift_id') ? old('shift_id') : $employee->shift_id?? '') == $shift->id ? 'selected' : '' }}>{{ $shift->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endif
                                        <!-- end -->
                                    </div>
                                </div>

                            </section>


                            <!-- Bank Information Form -->
                            <h3>Update Bank Info</h3>
                            <section id="bank_information">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group {{ $errors->has('account_holder_name') ? 'has-error' : '' }}">
                                            <label for="account_holder_name">{{ trans('cruds.employee.fields.account_holder_name') }}</label>
                                            <input class="form-control" type="text" name="account_holder_name" id="account_holder_name" value="{{ old('account_holder_name', $employee->account_holder_name) }}" placeholder="Your Account Name">
                                            @if($errors->has('account_holder_name'))
                                                <span class="help-block" role="alert">{{ $errors->first('account_holder_name') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.employee.fields.account_holder_name_helper') }}</span>
                                        </div>

                                        <div class="form-group {{ $errors->has('account_number') ? 'has-error' : '' }}">
                                            <label for="account_number">{{ trans('cruds.employee.fields.account_number') }}</label>
                                            <input class="form-control" type="number" name="account_number" id="account_number" value="{{ old('account_number', $employee->account_number) }}" placeholder="Your Account Number">
                                            @if($errors->has('account_number'))
                                                <span class="help-block" role="alert">{{ $errors->first('account_number') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.employee.fields.account_number_helper') }}</span>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group {{ $errors->has('bank_name') ? 'has-error' : '' }}">
                                            <label for="bank_name">{{ trans('cruds.employee.fields.bank_name') }}</label>
                                            <input class="form-control" type="text" name="bank_name" id="bank_name" value="{{ old('bank_name', $employee->bank_name) }}" placeholder="Your Bank Name">
                                            @if($errors->has('bank_name'))
                                                <span class="help-block" role="alert">{{ $errors->first('bank_name') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.employee.fields.bank_name_helper') }}</span>
                                        </div>
                                        <div class="form-group {{ $errors->has('branch_name') ? 'has-error' : '' }}">
                                            <label for="branch_name">{{ trans('cruds.employee.fields.branch_name') }}</label>
                                            <input class="form-control" type="text" name="branch_name" id="branch_name" value="{{ old('branch_name', $employee->branch_name) }}" placeholder="Bank Branch Name">
                                            @if($errors->has('branch_name'))
                                                <span class="help-block" role="alert">{{ $errors->first('branch_name') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.employee.fields.branch_name_helper') }}</span>
                                        </div>
                                    </div>
                                </div>

                            </section>


                            <!-- Documents Form -->
                            <h3>Update Documents</h3>
                            <section id="document_information">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group {{ $errors->has('certificates') ? 'has-error' : '' }}">
                                            <label for="certificates">{{ trans('cruds.employee.fields.certificates') }}</label>
                                            <div class="needsclick dropzone" id="certificates-dropzone">
                                            </div>
                                            @if($errors->has('certificates'))
                                                <span class="help-block" role="alert">{{ $errors->first('certificates') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.employee.fields.certificates_helper') }}</span>
                                        </div>

                                        <div class="form-group {{ $errors->has('noc') ? 'has-error' : '' }}">
                                            <label for="noc">{{ trans('cruds.employee.fields.noc') }}</label>
                                            <div class="needsclick dropzone" id="noc-dropzone">
                                            </div>
                                            @if($errors->has('noc'))
                                                <span class="help-block" role="alert">{{ $errors->first('noc') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.employee.fields.noc_helper') }}</span>
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group {{ $errors->has('resume') ? 'has-error' : '' }}">
                                            <label for="resume">{{ trans('cruds.employee.fields.resume') }}</label>
                                            <div class="needsclick dropzone" id="resume-dropzone">
                                            </div>
                                            @if($errors->has('resume'))
                                                <span class="help-block" role="alert">{{ $errors->first('resume') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.employee.fields.resume_helper') }}</span>
                                        </div>

                                        <div class="form-group {{ $errors->has('photo') ? 'has-error' : '' }}">
                                            <label for="photo">{{ trans('cruds.employee.fields.photo') }}</label>
                                            <div class="needsclick dropzone" id="photo-dropzone">
                                            </div>
                                            @if($errors->has('photo'))
                                                <span class="help-block" role="alert">{{ $errors->first('photo') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.employee.fields.photo_helper') }}</span>
                                        </div>
                                    </div>
                                </div>



                            </section>


                            <!-- Educational Information Form -->
                            <h3>Update Educational Setup</h3>
                            <section id="educational_information">
                                <div class="row">
                                    <div>
                                        @foreach($education as $key=> $result)
                                        <div class="employee_records">
                                            <div class="col-md-3">
                                                <label class="required" for="examination">{{ trans('cruds.education.fields.examination')  }} </label>
                                                <div class="form-group">
                                                    <input class="form-control" type="text" name="examination[]" id="examination" value="{{ old('examination',$result->examination) }}" placeholder="Your Degree Name">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="required" for="institute">{{ trans('cruds.education.fields.institute') }}</label>
                                                <div class="form-group">
                                                    <input class="form-control" type="text" name="institute[]" id="institute" value="{{ old('institute', $result->institue) }}" placeholder="Your Institute">
                                                </div>
                                            </div>
                                            <div class="col-md-2 " >
                                                <label class="required" for="passing_year">{{ trans('cruds.education.fields.passing_year') }}</label>
                                                <div class="form-group">
                                                    <input class="form-control" type="text" name="passing_year[]" id="hidden_passing_year" value="{{ old('passing_year', $result->passing_year) }}">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="required" for="result">{{ trans('cruds.education.fields.result') }}</label>
                                                <div class="form-group">
                                                    <input class="form-control" type="text" name="result[]" id="result" value="{{ old('result', $result->result) }}" placeholder="Your Result">
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach


                                        <div class="col-md-2 form-group">
                                            <a class="extra-fields-employee">
                                                <i class="fa fa-plus-circle" style="font-size:34px;float: right;margin-right:100px; margin-top: 18px;"></i>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="employee_records_dynamic"></div>
                                </div>


                            </section>

                            <h3>Update Salary Info</h3>
                            <section id="salary_information">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group  {{ $errors->has('salary') ? 'has-error' : '' }}">
                                            <label class="required" for="salary">{{ trans('cruds.employee.fields.salary') }}</label>
                                            <input class="form-control" type="number" name="salary" id="salary" value="{{ old('salary', $employee->salary) }}" required placeholder="Employee Salary">
                                            @if($errors->has('salary'))
                                                <span class="help-block" role="alert">{{ $errors->first('salary') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.employee.fields.salary_helper') }}</span>
                                            View Salary : <input type="checkbox" id="salary_disbursment" onclick="ShowHideDiv(this)">
                                        </div>

                                        <div class="form-group" style="display: none;" id="show_salary">
                                            <h3 style="padding: 10px;"><strong>Salary Disbersment</strong></h3>
                                            <table class="table" >
                                                <thead class="thead-light">
                                                <tr>
                                                    <th scope="col">Allowance </th>
                                                    <th scope="col">Percentage</th>
                                                    <th scope="col">Salary</th>
                                                </tr>
                                                </thead>
                                                <tbody id="salary_allowance_show">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group {{ $errors->has('marketing_allowance') ? 'has-error' : '' }}">
                                            <label for="marketing_allowance">{{ trans('cruds.employee.fields.marketing_allowance') }}</label>
                                            <input class="form-control" type="text" name="marketing_allowance" id="marketing_allowance" value="{{ old('marketing_allowance', $employee->marketing_allowance) }}">
                                            @if($errors->has('marketing_allowance'))
                                                <span class="help-block" role="alert">{{ $errors->first('marketing_allowance') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.employee.fields.marketing_allowance_helper') }}</span>
                                        </div>
                                        <div class="form-group {{ $errors->has('mobile_bill') ? 'has-error' : '' }}">
                                            <label for="mobile_bill">{{ trans('cruds.employee.fields.mobile_bill') }}</label>
                                            <input class="form-control" type="text" name="mobile_bill" id="mobile_bill" value="{{ old('mobile_bill', $employee->mobile_bill) }}">
                                            @if($errors->has('mobile_bill'))
                                                <span class="help-block" role="alert">{{ $errors->first('mobile_bill') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.employee.fields.mobile_bill_helper') }}</span>
                                        </div>
                                        <div class="form-group {{ $errors->has('provident_fund') ? 'has-error' : '' }}">
                                            <label for="provident_fund">{{ trans('cruds.employee.fields.provident_fund') }}</label>
                                            <input class="form-control" type="text" name="provident_fund" id="provident_fund" value="{{ old('provident_fund', $employee->provident_fund) }}">
                                            @if($errors->has('provident_fund'))
                                                <span class="help-block" role="alert">{{ $errors->first('provident_fund') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.employee.fields.provident_fund_helper') }}</span>
                                        </div>

                                        <div class="form-group {{ $errors->has('tax') ? 'has-error' : '' }}">
                                            <label for="tax">{{ trans('cruds.employee.fields.tax') }}</label>
                                            <input class="form-control" type="text" name="tax" id="tax" value="{{ old('tax', $employee->tax) }}" placeholder="0.00">
                                            @if($errors->has('tax'))
                                                <span class="help-block" role="alert">{{ $errors->first('tax') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.employee.fields.tax_helper') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-steps/1.1.0/jquery.steps.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script>
          var form = $("#basic-form");
            form.validate({
                errorPlacement: function errorPlacement(error, element) { element.before(error); }
            });
            $("#example-basic").steps({
                headerTag: "h3",
                bodyTag: "section",
                transitionEffect: "slideLeft",
                autoFocus: true,
                enableFinishButton: true,
                onStepChanging: function (event, currentIndex, newIndex)
                {
                    form.validate().settings.ignore = ":disabled,:hidden";
                    return form.valid();
                },
                onFinishing: function (event, currentIndex)
                {
                    form.validate().settings.ignore = ":disabled";
                    return form.valid();
                },
                onFinished: function (event, currentIndex)
                {
                    return form.submit();
                }

            });

    </script>

<!-- js for education form -->
<script>

    $(".extra-fields-employee").click(function() {
        $(".employee_records").clone().appendTo(".employee_records_dynamic");
        $(".employee_records_dynamic .employee_records").addClass("single remove");
        $(".single extra-fields-employee").remove();
        $(".single").append(
            '<a class="remove-field btn-remove-employee"><i class="fa fa-minus-circle" style="font-size:34px;float: right;margin-right:115px; margin-top: 20px;"></i></a>'
        );

        $(".employee_records_dynamic > .single").attr("class", "remove");

        $(".employee_records_dynamic input").each(function() {
            var count = 0;
            var fieldname = $(this).attr("name");
            $(this).attr("name", fieldname + count);
            count++;
        });
    });

    $(document).on("click", ".remove-field", function(e) {
        $(this).parent(".remove").remove();
        e.preventDefault();
    });
</script>


<script type="text/javascript">
    $(document).ready(function () {
        $(document).on('change', '#sub_company_id', function () {
            var id = $(this).val();
            $.ajax({
                type: 'get',
                url: '{{ route("admin.get_employee.department") }}',
                data: {'id': id},
                dataType: "json",
                success: function (data) {

                    if(data){
                        $('#department_id').empty();
                        $('#department_id').focus;
                        $('#department_id').append('<option value="0" required="" >Select Department </option>');
                        $.each(data, function(key, value){
                            $('select[name="department_id"]').append('<option value="'+ value.id +'">' + value.department_name+ '</option>');
                        });
                    }else{
                        $('#department_id').empty();
                    }
                },
                error: function () {

                }
            });
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
                        $('#employee_assign_to_id').empty();
                        $('#employee_assign_to_id').focus;
                        $('#employee_assign_to_id').append('<option value="0" required="" >Select Reporting Employee </option>');
                        $.each(data, function(key, value){
                            $('select[name="employee_assign_to_id"]').append('<option value="'+ value.id +'">' + value.first_name+' '+ value.last_name +'</option>');
                        });
                    }else{
                        $('#employee_assign_to_id').empty();
                    }
                },
                error: function () {

                }
            });
        });
    });
</script>
<!-- js for popup starts -->
<script>
    function checkUser() {
        var checkBox = document.getElementById("user_show");
        var text = document.getElementById("user_display");
        if (checkBox.checked == true){
            text.style.display = "block";
        } else {
            text.style.display = "none";
        }
    }

    function spouseDivShow() {
        var x = document.getElementById("myDIV");
        x.style.display = "block";
    }
    function spouseDivHidden() {
        var x = document.getElementById("myDIV");
        x.style.display = "none";
    }
</script>

<script type="text/javascript">
   function ShowHideDiv(salary_disbursment) {

            var salary = $('#salary').val();
            var x = document.getElementById("show_salary");
                        x.style.display = salary_disbursment.checked ? "block" : "none";
            $.get('/admin/salary/disbersment/' + salary, function(data) {
                    if(data.salary_allowances_count > 0){

                        $('#salary_allowance_show').empty();
                        var cols = "";
                        $.each(data.salary_allowances, function(key, value){
                            var percentage_salary = (value.percentage/100) * (data.tsalary) ;
                             cols+= `<tr>
                                            <td>${value.allowance_name}</td>
                                            <td>${value.percentage}</td>
                                            <td>${percentage_salary}</td>
                                      </tr>`
                        });
                        $('#salary_allowance_show').html(cols);
                    }else{
                        var x = document.getElementById("show_salary");
                        x.style.display = "none";
                    }


            });

    }
</script>


<script>
    var uploadedCertificatesMap = {}
    Dropzone.options.certificatesDropzone = {
        url: '{{ route('admin.employees.storeMedia') }}',
        maxFilesize: 2, // MB
        addRemoveLinks: true,
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        params: {
            size: 2
        },
        success: function(file, response) {
            $('form').append('<input type="hidden" name="certificates[]" value="' + response.name + '">')
            uploadedCertificatesMap[file.name] = response.name
        },
        removedfile: function(file) {
            file.previewElement.remove()
            var name = ''
            if (typeof file.file_name !== 'undefined') {
                name = file.file_name
            } else {
                name = uploadedCertificatesMap[file.name]
            }
            $('form').find('input[name="certificates[]"][value="' + name + '"]').remove()
        },
        init: function() {
            @if(isset($employee) && $employee -> certificates)
            var files = {!!json_encode($employee -> certificates) !!}
            for (var i in files) {
                var file = files[i]
                this.options.addedfile.call(this, file)
                file.previewElement.classList.add('dz-complete')
                $('form').append('<input type="hidden" name="certificates[]" value="' + file.file_name + '">')
            }
            @endif
        },
        error: function(file, response) {
            if ($.type(response) === 'string') {
                var message = response //dropzone sends it's own error messages in string
            } else {
                var message = response.errors.file
            }
            file.previewElement.classList.add('dz-error')
            _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
            _results = []
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                node = _ref[_i]
                _results.push(node.textContent = message)
            }

            return _results
        }
    }
</script>

<script>
    Dropzone.options.nocDropzone = {
        url: '{{ route('admin.employees.storeMedia') }}',
        maxFilesize: 2, // MB
        maxFiles: 1,
        addRemoveLinks: true,
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        params: {
            size: 2
        },
        success: function(file, response) {
            $('form').find('input[name="noc"]').remove()
            $('form').append('<input type="hidden" name="noc" value="' + response.name + '">')
        },
        removedfile: function(file) {
            file.previewElement.remove()
            if (file.status !== 'error') {
                $('form').find('input[name="noc"]').remove()
                this.options.maxFiles = this.options.maxFiles + 1
            }
        },
        init: function() {
            @if(isset($employee) && $employee -> noc)
            var file = {!!json_encode($employee -> noc) !!}
            this.options.addedfile.call(this, file)
            file.previewElement.classList.add('dz-complete')
            $('form').append('<input type="hidden" name="noc" value="' + file.file_name + '">')
            this.options.maxFiles = this.options.maxFiles - 1
            @endif
        },
        error: function(file, response) {
            if ($.type(response) === 'string') {
                var message = response //dropzone sends it's own error messages in string
            } else {
                var message = response.errors.file
            }
            file.previewElement.classList.add('dz-error')
            _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
            _results = []
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                node = _ref[_i]
                _results.push(node.textContent = message)
            }

            return _results
        }
    }
</script>

<script>
    Dropzone.options.resumeDropzone = {
        url: '{{ route('admin.employees.storeMedia') }}',
        maxFilesize: 2, // MB
        maxFiles: 1,
        addRemoveLinks: true,
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        params: {
            size: 2
        },
        success: function(file, response) {
            $('form').find('input[name="resume"]').remove()
            $('form').append('<input type="hidden" name="resume" value="' + response.name + '">')
        },
        removedfile: function(file) {
            file.previewElement.remove()
            if (file.status !== 'error') {
                $('form').find('input[name="resume"]').remove()
                this.options.maxFiles = this.options.maxFiles + 1
            }
        },
        init: function() {
            @if(isset($employee) && $employee -> resume)
            var file = {!!json_encode($employee -> resume) !!}
            this.options.addedfile.call(this, file)
            file.previewElement.classList.add('dz-complete')
            $('form').append('<input type="hidden" name="resume" value="' + file.file_name + '">')
            this.options.maxFiles = this.options.maxFiles - 1
            @endif
        },
        error: function(file, response) {
            if ($.type(response) === 'string') {
                var message = response //dropzone sends it's own error messages in string
            } else {
                var message = response.errors.file
            }
            file.previewElement.classList.add('dz-error')
            _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
            _results = []
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                node = _ref[_i]
                _results.push(node.textContent = message)
            }

            return _results
        }
    }
</script>


<script>
    Dropzone.options.photoDropzone = {
        url: '{{ route('admin.employees.storeMedia') }}',
        maxFilesize: 2, // MB
        acceptedFiles: '.jpeg,.jpg,.png,.gif',
        maxFiles: 1,
        addRemoveLinks: true,
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        params: {
            size: 2,
            width: 4096,
            height: 4096
        },
        success: function(file, response) {
            $('form').find('input[name="photo"]').remove()
            $('form').append('<input type="hidden" name="photo" value="' + response.name + '">')
        },
        removedfile: function(file) {
            file.previewElement.remove()
            if (file.status !== 'error') {
                $('form').find('input[name="photo"]').remove()
                this.options.maxFiles = this.options.maxFiles + 1
            }
        },
        init: function() {
            @if(isset($employee) && $employee -> photo)
            var file = {!!json_encode($employee->photo) !!}
            this.options.addedfile.call(this, file)
            this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
            file.previewElement.classList.add('dz-complete')
            $('form').append('<input type="hidden" name="photo" value="' + file.file_name + '">')
            this.options.maxFiles = this.options.maxFiles - 1
            @endif
        },
        error: function(file, response) {
            if ($.type(response) === 'string') {
                var message = response //dropzone sends it's own error messages in string
            } else {
                var message = response.errors.file
            }
            file.previewElement.classList.add('dz-error')
            _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
            _results = []
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                node = _ref[_i]
                _results.push(node.textContent = message)
            }

            return _results
        }
    }
</script>

<!-- attendance type js -->
<script type="text/javascript">
    $(document).ready(function () {
        $(document).on('change', '#attendance_type', function () {
            var type = $(this).val();
            if(type == 'Shift'){
             $('.showShift').show();
            }else{
                $('.showShift').hide();
            }
        });
    });
</script>
@endsection

