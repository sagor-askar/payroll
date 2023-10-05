@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Show Allowance Distribution
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.allowance-distribution.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        ID
                                    </th>
                                    <td>
                                        {{ $allowanceDistributionSetup->id }}
                                    </td>
                                </tr>

                                <tr>
                                    <th>
                                        Employee Name
                                    </th>
                                    <td>
                                        {{ $allowanceDistributionSetup->employee->first_name }}
                                    </td>
                                </tr>

                                <tr>
                                    <th>
                                        Allowance Name
                                    </th>
                                    <td>
                                        {{ $allowanceDistributionSetup->additional_allowance_setup->allowance_name  ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Allowance Amount
                                    </th>
                                    <td>
                                        {{ $allowanceDistributionSetup->allowance }}
                                    </td>
                                </tr>
                                
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.allowance-distribution.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>
</div>
@endsection