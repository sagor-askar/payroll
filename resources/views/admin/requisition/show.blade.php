@extends('layouts.admin')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Requisition Details
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.requisition.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                            @if($role_title == 'HR' || $role_title == 'Admin')
                                <div class="form-group" style="float: right">
                                    @if($requisitions->status == 1)
                                        <a  class="btn btn-xs btn-primary disabled" onclick="return approveFunction();" href="{{ route('admin.requisition.approve', $requisitions->id) }}">
                                            <i class="fa fa-check-circle" style="font-size:25px;color:limegreen" aria-hidden="true">Approved</i>
                                        </a>

                                        <a  class="btn btn-xs btn-danger" onclick="return cancelFunction();" style="display: inline-block;"href="{{ route('admin.requisition.cancel', $requisitions->id) }}">
                                            <i class="fa fa-times" style="font-size:25px;" aria-hidden="true">Cancel</i>
                                        </a>
                                    @else
                                        <a  class="btn btn-xs btn-primary" onclick="return approveFunction();" href="{{ route('admin.requisition.approve', $requisitions->id) }}">
                                            <i class="fa fa-check-circle" style="font-size:25px;color:limegreen" aria-hidden="true">Approve</i>
                                        </a>
                                    @endif
                                    @if($requisitions->status == 0)
                                        <a class="btn btn-xs btn-warning" onclick="return rejectFunction();" href="{{ route('admin.requisition.reject', $requisitions->id) }}">
                                            <i class="fa fa-times-circle" style="font-size:25px;color:red" aria-hidden="true">Reject</i>
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <div>
                            <h3 style=" border:10px;">Requisition Information</h3>
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
                                                {{$requisitions->employee->first_name.' '.$requisitions->employee->last_name}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Employee Id
                                            </th>
                                            <td>
                                            {{$requisitions->employee->employee_manual_id}}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>
                                                Status
                                            </th>
                                            @if($requisitions->status == 0)
                                                <td><strong style="color: #dd4b39"> Pending</strong> </td>
                                            @elseif($requisitions->status == 1)
                                                <td><strong style="color: darkgreen"> Approved</strong> </td>
                                            @else
                                                <td><strong style="color: red"> Rejected</strong> </td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <th>
                                                Approved By
                                            </th>
                                            <td>
                                                {{ $requisition->approved->name ?? ' '}}
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
                                            Department
                                        </th>
                                        <td>
                                            {{$requisitions->department->department_name}}
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>
                                            Expected Time Starts
                                        </th>
                                        <td>
                                            {{ $requisitions->start_date }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Expected Time Ends
                                        </th>
                                        <td>
                                            {{ $requisitions->end_date }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Reason
                                        </th>
                                        <td>
                                            {{$requisitions->reason}}
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
                                            <h3 style="border:10px;">Requisition Items Details</h3>
                                            <hr>
                                        </div>
                                        <div>
                                            <table class="table table-bordered table-striped">
                                                <thead style="background-color: #605CA8; color: white;">
                                                <tr>
                                                    <th scope="col">SL</th>
                                                    <th scope="col"> Items Name</th>
                                                    <th scope="col">Description</th>
                                                    <th scope="col">Qty</th>
                                                    <th scope="col">Unit Price</th>
                                                    <th scope="col">Total Price</th>
                                                </tr>
                                                </thead>
                                                @php
                                                $total = 0 ;
                                                @endphp
                                                <tbody>
                                                @foreach($requisitionsItems as $key=> $req_item)
                                                    @php
                                                        $total += $req_item->qty * $req_item->unit_price
                                                    @endphp
                                                    <tr>
                                                        <th scope="row">{{ $key+1}}</th>
                                                        <td>{{ $req_item->name}}</td>
                                                        <td>{{ $req_item->description}}</td>
                                                        <td>{{ $req_item->qty}}</td>
                                                        <td>{{ $req_item->unit_price}}  BDT</td>
                                                        <td>{{ $req_item->qty * $req_item->unit_price}}  BDT</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <th scope="row"></th>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td style="text-align: right;"><strong>Total : </strong></td>
                                                    <td><strong>{{$total}}  BDT</strong></td>
                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <a class="btn btn-default" href="{{ route('admin.requisition.index') }}">
                            {{ trans('global.back_to_list') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
