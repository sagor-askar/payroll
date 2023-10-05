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
                            <a class="btn btn-default" href="{{ route('admin.appointment.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>

                        <div class="col-md-12">
                            <div class="col-md-6">
                                <table class="table table-bordered table-striped">
                                    <tbody>
                                        <tr>
                                            <th>
                                                Applicant Name
                                            </th>
                                            <td>
                                                {{ $appointment->interview_result_candidate->candidate->name }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>
                                                Applicants Needs Documents?
                                            </th>
                                            <td>
                                                @if(count($appointment_documents) > 0 )
                                                    <ul> @foreach($appointment_documents as $key=> $val)
                                                            @php
                                                                $appointments_document = \App\Models\AppointmentChecklist::where('id',$val)->first();
                                                            @endphp
                                                            <li>{{$appointments_document->name}}</li>
                                                        @endforeach
                                                    </ul>

                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>
                                                Status
                                            </th>

                                            @if($appointment->status == 0)
                                                <td><strong style="color: #dd4b39">  Send</strong> </td>
                                            @else($interview_result->status == 1)
                                                <td><strong style="color: darkgreen"> Confirm</strong> </td>
                                            @endif
                                        </tr>

                                    </tbody>
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
