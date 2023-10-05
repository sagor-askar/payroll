@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Approval Attendance Information
                </div>
                <div class="panel-body">

                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.approveattendance.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>

                            
                            <div class="form-group" style="float: right">
                                @if($attendance_show->status == 1)
                                <a class="btn btn-xs btn-primary disabled" onclick="return approveFunction();" href="{{ route('admin.approveattendance.approve', $attendance_show->id) }}">
                                    <i class="fa fa-check-circle" style="font-size:25px;color:limegreen" aria-hidden="true">Approved</i>
                                </a>

                                <a class="btn btn-xs btn-danger" onclick="return cancelFunction();" style="display: inline-block;" href="{{ route('admin.approveattendance.cancel', $attendance_show->id) }}">
                                    <i class="fa fa-times" style="font-size:25px;" aria-hidden="true">Cancel</i>
                                </a>
                                @else
                                <a class="btn btn-xs btn-primary" onclick="return approveFunction();" href="{{ route('admin.approveattendance.approve', $attendance_show->id) }}">
                                    <i class="fa fa-check-circle" style="font-size:25px;color:limegreen" aria-hidden="true">Approve</i>
                                </a>
                                @endif
                            </div>
                           

                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                               <tr>
                                    <div>
                                        <input type="hidden" id="getlatitude"  value="{{$attendance_show->latitude}}">
                                    </div>
                                    <div>
                                        <input type="hidden" id="getlongitude"  value="{{$attendance_show->longitude}}">
                                    </div>
                                </tr>
                                <tr>
                                    <th>
                                        Employee ID
                                    </th>
                                    <td>
                                        {{ $attendance_show->employee_id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Employee Name
                                    </th>
                                    <td>
                                        {{ $attendance_show->employee->first_name.' '.$attendance_show->employee->last_name }}
                                    </td>
                                </tr>

                                <tr>
                                    <th>
                                        Date
                                    </th>
                                    <td>
                                        {{ $attendance_show->authDate }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Clock In Time
                                    </th>
                                    <td>
                                        {{ $attendance_show->authTime }}
                                    </td>
                                </tr>

                                <tr>
                                    <th>
                                        Device Name
                                    </th>
                                    <td>
                                        {{ $attendance_show->deviceName }}
                                    </td>
                                </tr>



                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.approveattendance.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- map starts -->
            <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp%22%3E"></script>
            <div id="map" style="width: 100%; height: 280px; background-color: grey;">
            </div>
            <!-- map ends -->

        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- js for map -->
<script>
    
    window.onload = function() {
     
        var latitude = $('#getlatitude').val();
        var longitude = $('#getlongitude').val();
       
        var latlng = new google.maps.LatLng(latitude , longitude);
        var map = new google.maps.Map(document.getElementById('map'), {
            center: latlng,
            zoom: 11,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        var marker = new google.maps.Marker({
            position: latlng,
            map: map,
            title: 'Place the marker for your location!', 
            draggable: true 
        });

        google.maps.event.addListener(marker, 'dragend', function(a) {
            console.log(a);
            document.getElementById('loc').value = a.latLng.lat().toFixed(4) + ', ' + a.latLng.lng().toFixed(4); //Place the value in input box
        });
    };
</script>

<!-- js for approval -->
<script>
    function approveFunction() {
        if (!confirm("You are going to Approve !"))
            event.preventDefault();
    }
</script>
@endsection