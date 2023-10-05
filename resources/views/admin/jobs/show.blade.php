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
                                @if($jobs->approve_status == 1)
                                <a  class="btn btn-xs btn-primary disabled" onclick="return approveFunction();" href="{{ route('admin.jobs.approve', $jobs->id) }}">
                                    <i class="fa fa-check-circle" style="font-size:25px;color:limegreen" aria-hidden="true">Approved</i>
                                </a>

                                <a  class="btn btn-xs btn-danger" onclick="return cancelFunction();" style="display: inline-block;"href="{{ route('admin.jobs.cancel', $jobs->id) }}">
                                    <i class="fa fa-times" style="font-size:25px;" aria-hidden="true">Cancel</i>
                                </a>

                                @else
                                <a  class="btn btn-xs btn-primary" onclick="return approveFunction();" href="{{ route('admin.jobs.approve', $jobs->id) }}">
                                    <i class="fa fa-check-circle" style="font-size:25px;color:limegreen" aria-hidden="true">Approve</i>
                                </a>
                               @endif

                               @if($jobs->approve_status == 0)
                                <a class="btn btn-xs btn-warning" onclick="return rejectFunction();" href="{{ route('admin.jobs.reject', $jobs->id) }}">
                                    <i class="fa fa-times-circle" style="font-size:25px;color:red" aria-hidden="true">Reject</i>
                                </a>
                              @endif

                            </div>
                          @endif
                        </div>

                        <div class="row">
                            <div class="col-md-6">
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
                                        Need To Ask?
                                    </th>
                                    <td>
                                        @if(count($askarray) > 0 )
                                            <ul> @foreach($askarray as $key=> $val)
                                                    <li>{{$val}}</li>
                                                @endforeach
                                            </ul>

                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <th>
                                        Need To Show Option ?
                                    </th>
                                    <td>
                                        @if(count($showOptionArray) > 0 )
                                            <ul> @foreach($showOptionArray as $key=> $val)
                                                    <li>{{$val}}</li>
                                                @endforeach
                                            </ul>
                                            @endif
                                    </td>
                                </tr>

                                    <tr>
                                        <th>
                                            Custom Question ?
                                        </th>
                                        <td>
                                            @if(count($customArray) > 0 )
                                                <ul> @foreach($customArray as $key=> $val)
                                                         @php
                                                         $questions = \App\Models\CustomQuestion::where('id',$val)->first();
                                                         @endphp
                                                        <li>{{$questions->question}}</li>
                                                    @endforeach
                                                </ul>

                                        @endif
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

                                <tr>
                                    <th>
                                        Approved By
                                    </th>
                                    <td>
                                        {{ $jobs->approved_by->name ?? '' }}
                                    </td>
                                </tr>

                                <tr>
                                    <th>
                                        Circulated Status
                                    </th>
                                    @if($jobs->circulate_status==0)
                                        <td style="color: red">Inactive </td>
                                    @else
                                        <td style="color: green">Active </td>
                                    @endif
                                </tr>

                                <tr>
                                    <th>
                                        Approve Status
                                    </th>
                                    @if($jobs->approve_status==0)
                                        <td style="color: orangered">Pending </td>
                                    @elseif($jobs->approve_status==1)
                                        <td style="color: green">Approved </td>
                                    @else
                                        <td style="color: red">Rejected </td>
                                    @endif
                                </tr>
                                    </tbody>
                                </table>
                            </div>
                            <table class="table table-bordered table-striped">
                                <tbody>
                                <tr>
                                    <th>
                                        Job Requirement
                                    </th>
                                    <td>
                                        {!! $jobs->job_requirement !!}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Job Description
                                    </th>
                                    <td>
                                        {!! $jobs->job_description !!}
                                    </td>
                                </tr>


                                </tbody>
                            </table>
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
