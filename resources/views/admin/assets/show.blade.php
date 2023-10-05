@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Assets Information
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.assets.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        Asset Name
                                    </th>
                                    <td>
                                        {{$asset->name}}
                                    </td>
                                </tr>

                                <tr>
                                    <th>
                                        Asset Code
                                    </th>
                                    <td>
                                       {{$asset->asset_code}} 
                                        <button  style="float: right;" type="button" class="btn btn-warning text-right" id="btnPrint" onclick="printPageArea('printableArea');">
                                            <i class="fa fa-print"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                     Group
                                    </th>
                                    <td>
                                        {{$asset->asset_group->name}}
                                    </td>
                                </tr>

                                <tr>
                                    <th>
                                        Date of Purchase
                                    </th>
                                    <td>
                                        {{ \Carbon\Carbon::parse($asset->purchase_date)->format('d-m-Y') }}
                                    </td>
                                </tr>
                                
                                <tr>
                                    <th>
                                        Warranty Period
                                    </th>
                                    <td>
                                        {{ $asset->warranty_period }}
                                    </td>
                                </tr>

                            <tr>
                                <th>
                                    Qty
                                </th>
                                <td>
                                    {{ $asset->qty }}
                                </td>
                            </tr>
                                <tr>
                                    <th>
                                        Unit Price
                                    </th>
                                    <td>
                                        {{ $asset->unit_price }}
                                    </td>
                                </tr>

                                <tr>
                                    <th>
                                        Supplier Name
                                    </th>
                                    <td>
                                        {{ $asset->supplier_name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Supplier Phone
                                    </th>
                                    <td>
                                        {{ $asset->supplier_phone }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Supplier Address
                                    </th>
                                    <td>
                                        {{ $asset->supplier_address }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Assets Assigned To
                                    </th>
                                    <td>
                                        {{ $asset->assigned_employee->first_name}} {{ $asset->assigned_employee->last_name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Description
                                    </th>
                                    <td>
                                        {!! $asset->description !!}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.assets.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- printable area for asset code-->
            <div style="display: none;" class="table-responsive" id="printableArea">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Asset Code</th>
                            <th scope="col">Assigned To</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$asset->asset_code}}</td>
                            <td>{{ $asset->assigned_employee->first_name}} {{ $asset->assigned_employee->last_name }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
        function printPageArea(printableArea) {

            var printContents = document.getElementById("printableArea").innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();
            window.close();

            document.body.innerHTML = originalContents;
        }
    </script>
@endsection
