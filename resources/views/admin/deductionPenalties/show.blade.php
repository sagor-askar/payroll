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
                            <a class="btn btn-default" href="{{ route('admin.deduction-penalties.index') }}">
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
                                        {{ $deductionPenaltiesSetup->id }}
                                    </td>
                                </tr>

                                <tr>
                                    <th>
                                        Employee Name
                                    </th>
                                    <td>
                                        {{ $deductionPenaltiesSetup->employee->first_name }}
                                    </td>
                                </tr>

                                <tr>
                                    <th>
                                        Deduction Name
                                    </th>
                                    <td>
                                        {{ $deductionPenaltiesSetup->additional_deduction_setup->deduction_name  ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Deduction Amount
                                    </th>
                                    <td>
                                        {{ $deductionPenaltiesSetup->deduction }}
                                    </td>
                                </tr>
                                
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.deduction-penalties.index') }}">
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