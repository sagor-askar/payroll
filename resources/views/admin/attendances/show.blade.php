@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.show') }} {{ trans('cruds.attendance.title') }}
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.attendances.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.attendance.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $attendance->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.attendance.fields.employee') }}
                                    </th>
                                    <td>
                                        {{ $attendance->employee->first_name.' '.$attendance->employee->last_name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.attendance.fields.date') }}
                                    </th>
                                    <td>
                                        {{ $attendance->date }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.attendance.fields.clock_in') }}
                                    </th>
                                    <td>
                                        {{ $attendance->clock_in }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.attendance.fields.clock_out') }}
                                    </th>
                                    <td>
                                        {{ $attendance->clock_out }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.attendance.fields.late') }}
                                    </th>
                                    <td>
                                        {{ $attendance->late }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.attendance.fields.early_leaving') }}
                                    </th>
                                    <td>
                                        {{ $attendance->early_leaving }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.attendance.fields.total_work') }}
                                    </th>
                                    <td>
                                        {{ $attendance->total_work }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.attendance.fields.area') }}
                                    </th>
                                    <td>
                                        {{ $attendance->area }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.attendances.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- location on map -->

            <div id="map" style="width: 100%;height: 280px; background-color: grey;">
            </div>  

            <!-- map start -->
            <script type='text/javascript' src='https://maps.googleapis.com/maps/api/js?key=AIzaSyDXJNhJI9Qtfgap9aozUd8-oZ2bg5ky1h8&callback=initMap%27%3E&callback=initMap'></script>
            <script type='text/javascript'>
                var map;
                function initialize() {
                //window.alert('hey');
                navigator.geolocation.getCurrentPosition(
                    function (position) {
                    console.log("user location position:",position)
                    initMap(position.coords.latitude, position.coords.longitude);
                    function initMap(lat, lng) {
                        var myLatLng = {
                            lat,
                            lng,
                        };
                    var map = new google.maps.Map(document.getElementById("map"), {
                            zoom: 15,
                            center: myLatLng,
                        });
                    var marker = new google.maps.Marker({
                            position: myLatLng,
                            map: map,
                        });
                    }
                },
                function errorCallback(error) {
                    console.log(error);
                    document.getElementById("map_card").style.display = 'none'
                }
            );
            }
            google.maps.event.addDomListener(window, 'load', initialize);
            </script>
            <!-- map end -->


        </div>
    </div>
</div>
@endsection