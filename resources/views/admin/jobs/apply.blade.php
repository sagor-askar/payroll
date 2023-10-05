@extends('layouts.admin')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Job Apply
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="form-group">
                                <a class="btn btn-default" href="{{ route('admin.jobs.index') }}">
                                    {{ trans('global.back_to_list') }}
                                </a>

                                <div style="float: right">
                                    <input type="button" id="btn" class="btn btn-success" value="Create Apply">
                                </div>



                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <table class="table table-bordered table-striped">
                                        <tbody>
                                        <tr>
                                            <th>
                                                Job Title
                                            </th>
                                            <td>
                                                {{ $jobs->job_title }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Department
                                            </th>
                                            <td>
                                                {{ $jobs->department->department_name }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Job Type
                                            </th>

                                            @if($jobs->job_type == 0)
                                                <td >Internship </td>
                                            @elseif($jobs->job_type ==1)
                                                <td>Part Time </td>
                                            @elseif($jobs->job_type ==2)
                                                <td >Full Time </td>
                                            @else
                                                <td >Contactual </td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <th>
                                                No Of Position
                                            </th>
                                            <td>
                                                {{ $jobs->no_of_positions ?? '' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Skills
                                            </th>
                                            <td>
                                                {{ $jobs->skills ?? '' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Office Time
                                            </th>
                                            <td>
                                                {{ $jobs->office_time ?? '' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Salary Range
                                            </th>
                                            <td>
                                                {{ $jobs->salary_range ?? '' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Location
                                            </th>
                                            <td>
                                                {{ $jobs->location }}

                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Deadline
                                            </th>
                                            <td style="color: red">
                                                <strong>{{ $jobs->end_date }}</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Circulated By
                                            </th>
                                            <td>
                                                {{ $jobs->created_by->name ?? '' }}
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-8">
                                    <div>
                                        <div>
                                            <h4> Job Requirement</h4>
                                        </div>
                                        <hr>
                                        <div>
                                            <p>{!! $jobs->job_requirement !!}</p>
                                        </div>
                                    </div>
                                    <br>
                                    <br>

                                    <div>
                                        <div>
                                            <h4>   Job Description</h4>
                                        </div>
                                        <hr>
                                        <div>
                                            <p>{!! $jobs->job_description !!}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <br>
                            <br>

                            <div class="panel panel-default" id="Create" style="display:none">
                                <div class="panel-heading text-center" >
                                 <strong>Create Job Application</strong>
                                </div>
                            <div class="panel-body">
                                <form method="POST" action="{{ route("admin.jobs.jobApplyStore") }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row" >
                                        <div class=" col-md-6">
                                            <div class="form-group">
                                                <label class="required" for="job_title"> Full Name</label>
                                                <input type="hidden" name="job_id"  value="{{ $jobs->id }}">
                                                <input class="form-control" type="text" name="name" id="name" value="{{ old('name') }}" required>
                                                @if($errors->has('name'))
                                                    <span class="help-block" role="alert">{{ $errors->first('name') }}</span>
                                                @endif
                                            </div>

                                            @if(in_array('gender', $askarray))
                                                <div class="form-group">
                                                    <label class="required" for="gender"> Gender</label>
                                                    <select class="form-control" name="gender" id="gender" required>
                                                        <option value="">Select One</option>
                                                            <option value="Male">Male</option>
                                                            <option value="Female">Female</option>
                                                    </select>
                                                    @if($errors->has('gender'))
                                                        <span class="help-block" role="alert">{{ $errors->first('gender') }}</span>
                                                    @endif
                                                </div>
                                            @endif

                                            <div class="form-group">
                                                <label class="required" for="apply_date"> Apply Date</label>
                                                <input class="form-control date" type="text" name="apply_date" id="apply_date" value="{{ old('apply_date') }}" required>
                                                @if($errors->has('apply_date'))
                                                    <span class="help-block" role="alert">{{ $errors->first('apply_date') }}</span>
                                                @endif
                                            </div>

                                            @if(in_array('dob', $askarray))
                                                <div class="form-group">
                                                    <label class="required" for="dob"> Date Of Birth</label>
                                                    <input class="form-control date" type="text" name="dob" id="dob" value="{{ old('dob') }}" required>
                                                    @if($errors->has('dob'))
                                                        <span class="help-block" role="alert">{{ $errors->first('dob') }}</span>
                                                    @endif
                                                </div>
                                            @endif

                                            @if(in_array('image', $showOptionArray))
                                                <div class="form-group">
                                                    <label class="required" for="image"> Image</label>
                                                    <input class="form-control" type="file" name="image" id="image" value="{{ old('image') }}" required>
                                                    @if($errors->has('image'))
                                                        <span class="help-block" role="alert">{{ $errors->first('image') }}</span>
                                                    @endif
                                                </div>
                                            @endif


                          </div>

                                <div class=" col-md-6">
                                            <div class="form-group">
                                                <label class="required" for="job_title"> Email</label>
                                                <input class="form-control" type="email" name="email" id="email" value="{{ old('email') }}" required>
                                                @if($errors->has('email'))
                                                    <span class="help-block" role="alert">{{ $errors->first('email') }}</span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label class="required" for="job_title"> Phone</label>
                                                <input class="form-control" type="text" name="phone" id="phone" value="{{ old('phone') }}" required>
                                                @if($errors->has('phone'))
                                                    <span class="help-block" role="alert">{{ $errors->first('phone') }}</span>
                                                @endif
                                            </div>
                                    @if(in_array('resume', $showOptionArray))
                                        <div class="form-group">
                                            <label class="required" for="resume"> Resume</label>
                                            <input class="form-control" type="file" name="resume" id="resume" value="{{ old('resume') }}" required>
                                            @if($errors->has('gender'))
                                                <span class="help-block" role="alert">{{ $errors->first('gender') }}</span>
                                            @endif
                                        </div>
                                    @endif


                                    @if(in_array('cover_letter', $showOptionArray))
                                        <div class="form-group">
                                            <label for="cover_letter"> Cover Letter</label>
                                            <input class="form-control" type="file" name="cover_letter" id="cover_letter" value="{{ old('cover_letter') }}">
                                            @if($errors->has('cover_letter'))
                                                <span class="help-block" role="alert">{{ $errors->first('cover_letter') }}</span>
                                            @endif
                                        </div>
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





                            <div>
                            </div>
                            <div class="form-group">
                                <a class="btn btn-default" href="{{ route('admin.jobs.index') }}">
                                    {{ trans('global.back_to_list') }}
                                </a>
                            </div>
                        </div>
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

    <script>
        ClassicEditor
            .create(document.querySelector('#requirementstyle'))
            .catch(error =>{
                console.log(error);
            });
    </script>

    <script>
        function rejectFunction() {
            if(!confirm("Are You Sure to Reject ?"))
                event.preventDefault();
        }
    </script>

    <script>
        function approveFunction() {
            if(!confirm("You are going to Approve !"))
                event.preventDefault();
        }
    </script>

    <script>
        function cancelFunction() {
            if (confirm('{{ trans('global.areYouSure') }}')) {
                $.ajax({
                    headers: {'x-csrf-token': _token},
                    method: 'POST',
                    url: config.url,
                    data: { ids: ids, _method: 'DELETE' }})
                    .done(function () { location.reload() })
            }
        }
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#btn').click(function() {
                $('#Create').animate({
                    height: 'show'
                }, 1500, function() {
                });
            });
        });
    </script>



@endsection

