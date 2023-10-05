@extends('layouts.admin')
@section('content')

<div class="content">
    @php
        $show_start_date = \Carbon\Carbon::parse($start_date)->format('d-m-Y');
        $show_end_date = \Carbon\Carbon::parse($end_date)->format('d-m-Y');
    @endphp
    <div class="row">
        <div class="col-lg-12" >
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 style="color: #605CA8;"><b>Attendance History</b></h4>
                </div>
                <div class="panel-body" id="printarea">
                    <form method="POST" action="{{ route("admin.attendances.store") }}" enctype="multipart/form-data">
                        @csrf
                        <div class="text-right">
                            <button type="button" class="btn btn-warning"  onclick="print(printarea);" autocomplete="">
                                <i class="fa fa-print"></i>
                            </button>
                        </div>
                        <br>

                        <p style="text-align: center; font-size: 20px; color: #605CA8;"><b>PAYROLL</b></p>

                        <p style="font-size: 18px; Text-align: center;">{{ $attendance_history[0]->employee->first_name .' '.$attendance_history[0]->employee->last_name }}</p>
                        <br>

                        <table class="table table-bordered"  >
                            <caption>Attendance History <strong>( From {{ $show_start_date }} To {{ $show_end_date }} )</strong></caption>
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Clock In</th>
                                    <th scope="col">Clock Out</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($attendance_history as $key=> $attendance)
                                <tr>
                                    <th scope="row">{{$key +1}}</th>
                                    <td>{{$attendance->clock_in}}</td>
                                    <td>{{$attendance->clock_out}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<style>
    @media print {
        body * {
            visibility: hidden;
        }
        .body navbar{
            visibility: hidden;
        }
        #printarea, #printarea * {
            visibility: visible;
        }
        #printarea {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
    }
</style>

