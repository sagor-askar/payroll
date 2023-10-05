@extends('layouts.admin')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Conveyance Details
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.conveyance.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>

                            <a style="float: right" type="button" class="btn btn-primary" href=" {{ route('admin.conveyance.pdf',$conveyances->id) }}"><i class="fa fa-print" title="Print From Here"></i></a><hr>
                        </div>
                        @if($role_title == 'HR')
                            <div class="form-group" style="float: right">
                                @if($conveyances->status == 1)
                                    <a  class="btn btn-xs btn-primary disabled" onclick="return approveFunction();" href="{{ route('admin.conveyance.approve', $conveyances->id) }}">
                                        <i class="fa fa-check-circle" style="font-size:25px;color:limegreen" aria-hidden="true">Approved</i>
                                    </a>
                                    <a  class="btn btn-xs btn-danger" onclick="return cancelFunction();" style="display: inline-block;"href="{{ route('admin.conveyance.cancel', $conveyances->id) }}">
                                        <i class="fa fa-times" style="font-size:25px;" aria-hidden="true">Cancel</i>
                                    </a>
                                @else
                                    <a  class="btn btn-xs btn-primary" onclick="return approveFunction();" href="{{ route('admin.conveyance.approve', $conveyances->id) }}">
                                        <i class="fa fa-check-circle" style="font-size:25px;color:limegreen" aria-hidden="true">Approve</i>
                                    </a>

                                    <a  class="btn btn-xs btn-warning" onclick="return approveFunction();" href="{{ route('admin.conveyance.forward', $conveyances->id) }}">
                                        <i class="fa fa-check-circle" style="font-size:25px;" aria-hidden="true">Forward</i>
                                    </a>

                                @endif
                                @if($conveyances->status == 0)
                                    <a class="btn btn-xs btn-warning" onclick="return rejectFunction();" href="{{ route('admin.conveyance.reject', $conveyances->id) }}">
                                        <i class="fa fa-times-circle" style="font-size:25px;color:red" aria-hidden="true">Reject</i>
                                    </a>
                                @endif

                            </div>
                            @elseif($role_title == 'Admin')
                            <div class="form-group" style="float: right">
                                @if($conveyances->status == 1)
                                    <a  class="btn btn-xs btn-primary disabled" onclick="return approveFunction();" href="{{ route('admin.conveyance.approve', $conveyances->id) }}">
                                        <i class="fa fa-check-circle" style="font-size:25px;color:limegreen" aria-hidden="true">Approved</i>
                                    </a>
                                    <a  class="btn btn-xs btn-danger" onclick="return cancelFunction();" style="display: inline-block;"href="{{ route('admin.conveyance.cancel', $conveyances->id) }}">
                                        <i class="fa fa-times" style="font-size:25px;" aria-hidden="true">Cancel</i>
                                    </a>
                                @else
                                    <a  class="btn btn-xs btn-primary" onclick="return approveFunction();" href="{{ route('admin.conveyance.approve', $conveyances->id) }}">
                                        <i class="fa fa-check-circle" style="font-size:25px;color:limegreen" aria-hidden="true">Approve</i>
                                    </a>
                                @endif
                                    <a class="btn btn-xs btn-warning" onclick="return rejectFunction();" href="{{ route('admin.conveyance.reject', $conveyances->id) }}">
                                        <i class="fa fa-times-circle" style="font-size:25px;color:red" aria-hidden="true">Reject</i>
                                    </a>
                            </div>
                            @else
                            @endif


                        <div>
                            <h3 style=" border:10px;">Employee's Conveyance Information</h3>
                            <hr>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-bordered table-striped">
                                    <tbody>
                                        <tr>
                                            <th>
                                                Employee Name
                                            </th>
                                            <td>
                                                {{$conveyances->employee->first_name.' '.$conveyances->employee->last_name}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Department
                                            </th>
                                            <td>
                                                {{ $conveyances->department->department_name}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Designation
                                            </th>
                                            <td>
                                                {{ $conveyances->designation->designation_name }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>
                                                Date
                                            </th>
                                            <td>
                                                {{ $conveyances->conveyance_date }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div>
                                            <h3 style="border:10px;">Conveyance Items Details</h3>
                                            <hr>
                                        </div>
                                        <div>
                                            <table class="table table-sm table-bordered table-striped table-hover">
                                                <thead style="background-color: #605CA8; color: white;">
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Description</th>
                                                        <th scope="col">From Place</th>
                                                        <th scope="col">To Place</th>
                                                        <th scope="col">Mode of Transportation</th>
                                                        <th scope="col">Amount</th>
                                                    </tr>
                                                </thead>
                                                @php
                                                    $total = 0;
                                                @endphp
                                                <tbody>
                                                    @foreach($conveyanceItems as $key=>$conv_item)
                                                        @php
                                                            $total += $conv_item->cost
                                                        @endphp
                                                    <tr>
                                                        <th scope="row">{{ $key+1 }}</th>

                                                        <td>{{ $conv_item->description }}</td>

                                                        <td>{{ $conv_item->from_place }}</td>

                                                        <td>{{ $conv_item->to_place }}</td>

                                                        <td>{{ $conv_item->mode_of_transport }}</td>

                                                        <td>{{ $conv_item->cost }}</td>
                                                    </tr>
                                                    @endforeach

{{--                                                    @php--}}
{{--                                                        $f = new \NumberFormatter( locale_get_default(), \NumberFormatter::SPELLOUT );--}}
{{--                                                        $word =ucwords($f->format($total)) ;--}}
{{--                                                    @endphp--}}

                                                    <tr>
                                                        <th scope="row"></th>
{{--                                                        <td><b>In Words: </b> {{$word}} Taka Only.</td>--}}
                                                        <td></td>
                                                        <td></td>
                                                        <td><b style="float: right;">Total Cost :</b></td>
                                                        <td colspan="1"><b>{{ $total }} BDT </b></td>
                                                        <td></td>
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

        </div>
    </div>
</div>
@endsection
