@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Interview - Evaluation Details
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.interview.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>

                        <div class="col-md-12">
                            <div class="col-md-6">
                                <table class="table table-bordered table-striped">
                                    <tbody>
                                        <tr>
                                            <th>
                                                Candidate Name
                                            </th>
                                            <td>
                                                {{ $interview_result->candidate->name }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>
                                                Interview Date
                                            </th>
                                            <td>
                                                {{ $interview_result->interview_date }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>
                                                Job Position
                                            </th>
                                            <td>
                                                {{ $interview_result->job->job_title }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>
                                                Interviewer
                                            </th>
                                            <td>
                                                {{ $interview_result->interview_date }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>
                                                Recommandation
                                            </th>
                                            <td>
                                                {{ $interview_result->recommandation }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>
                                                Viva Marks
                                            </th>
                                            <td>
                                                {{ $interview_result->viva_marks }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>
                                                MCQ Marks
                                            </th>
                                            <td>
                                                {{ $interview_result->mcq_marks }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>
                                                Written Marks
                                            </th>
                                            <td>
                                                {{ $interview_result->written_marks }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>
                                                Total Marks
                                            </th>
                                            <td>
                                                {{ $interview_result->total_marks }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>
                                                Recommandation
                                            </th>
                                            <td>
                                                {{ $interview_result->recommandation }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>
                                                Interviewer
                                            </th>
                                            <td>
                                                {{ $interview_result->interviewer }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>
                                                Status
                                            </th>

                                            @if($interview_result->status == 0)
                                                <td><strong style="color: #dd4b39"> Not Selected</strong> </td>
                                            @else($interview_result->status == 1)
                                                <td><strong style="color: darkgreen"> Selected</strong> </td>
                                            @endif
                                        </tr>

                                    </tbody>
                                </table>
                            </div>

                            <div class="col-md-6">
                                <table>
                                    <tr>
                                        <h4> Details </h4>
                                        <td style="width: 100%; text-align: justify;">
                                            {{ $interview_result->details }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
