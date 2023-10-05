@extends('layouts.admin')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.show') }} Job Application
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.jobs.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>

                           @if($role_title == 'HR' || $role_title == 'Admin')
                            <div class="form-group" style="float: right">
                                <a  class="btn btn-xs btn-primary" onclick="return approveFunction();" href="{{ route('admin.candidate.shortlist', $candidates->id) }}">
                                    <i class="fa fa-check-circle" style="font-size:25px;color:limegreen" aria-hidden="true">Shortlist</i>
                                </a>

                                <a  class="btn btn-xs btn-danger" onclick="return cancelFunction();" style="display: inline-block;"href="{{ route('admin.candidate.cancel', $candidates->id) }}">
                                    <i class="fa fa-times" style="font-size:25px;" aria-hidden="true">Cancel</i>
                                </a>
                            </div>
                          @endif
                        </div>
                        <div class="text-center" style="margin-left: 150px;">
                            <h4> Job  Summary </h4>
                        </div>
                        <div class="row">

                            <div class="col-md-6">
                                <table class="table table-bordered table-striped">
                                    <tbody>

                                    <tr>
                                    <th>
                                       <div>
                                       <img src="{{url('images/job-application/image/',$candidates->image)}}"  alt="" height="auto" width="70px">
                                       </div>
                                     </th>
                                    </tr>

                                <tr>
                                    <th>
                                       Full Name
                                    </th>
                                    <td>
                                        {{ $candidates->name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                       Email
                                    </th>
                                    <td>
                                        {{ $candidates->email ?? '' }}
                                    </td>
                                </tr>

                                <tr>
                                    <th>
                                       Phone Number
                                    </th>
                                    <td>
                                        {{ $candidates->phone ?? '' }}
                                    </td>
                                </tr>

                                <tr>
                                    <th>
                                        Date Of Birth
                                    </th>
                                    <td>
                                        {{ $candidates->dob ?? '' }}
                                    </td>
                                </tr>

                                <tr>
                                    <th>
                                       Gender
                                    </th>
                                    <td>
                                        {{ $candidates->gender ?? '' }}
                                    </td>
                                </tr>

                                    <tr>
                                        <th>
                                            Resume
                                        </th>
                                        <td>
                                            {{$candidates->resume}}
                                            <div class="row" style="display: inline ">
                                                <div>
                                                    <a style="float: left" href="{{ route('admin.candidate.resumeDownload', $candidates->id) }}" ><i class="fa fa-download"></i> Download</a>

                                                    <a style="margin-left: 30px;" target="_blank"  href="{{ route('admin.candidate.resumeOpen', $candidates->id) }}" ><i class="fas fa-folder-open"></i> Open</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Cover Letter
                                        </th>
                                        <td>
                                            {{$candidates->cover_letter}}
                                            <div class="row" style="display: inline ">
                                                <div>
                                                    <a style="float: left" href="{{ route('admin.candidate.coverLatterDownload', $candidates->id) }}" ><i class="fa fa-download"></i> Download</a>

                                                    <a style="margin-left: 30px;" target="_blank"  href="{{ route('admin.candidate.coverLatterOpen', $candidates->id) }}" ><i class="fas fa-folder-open"></i> Open</a>
                                                </div>
                                            </div>

                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-md-6">
                                <table class="table table-bordered table-striped">
                                    <tbody>
                                    <tr>
                                        <th>
                                            Job Title
                                        </th>
                                        <td>
                                            {{ $candidates->job->job_title ?? '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            No Of Position
                                        </th>
                                        <td>
                                            {{ $candidates->job->no_of_positions ?? '' }}
                                        </td>
                                    </tr>
                                <tr>
                                    <th>
                                        Skills
                                    </th>
                                    <td>
                                        {{ $candidates->job->skills ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Office Time
                                    </th>
                                    <td>
                                        {{ $candidates->job->office_time ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Salary Range
                                    </th>
                                    <td>
                                        {{ $candidates->job->salary_range ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Location
                                    </th>
                                    <td>
                                        {{ $candidates->job->location }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Deadline
                                    </th>
                                    <td style="color: red">
                                        <strong>{{ $candidates->job->end_date }}</strong>
                                    </td>
                                </tr>
                                    </tbody>
                                </table>
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
@endsection
