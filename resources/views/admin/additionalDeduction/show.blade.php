@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Show Additional Allowance
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.additional-deduction.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        Company
                                    </th>
                                    <td>
                                        {{ $additionalDeductionSetup->company->comp_name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Sub-Company
                                    </th>
                                    <td>
                                        {{ $additionalDeductionSetup->sub_company->sub_company_name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Deduction Name
                                    </th>
                                    <td>
                                        {{ $additionalDeductionSetup->deduction_name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Status
                                    </th>
                                    @if($additionalDeductionSetup->status == 1)
                                    <td>
                                        Active
                                    </td>
                                    @else
                                    <td>
                                        Inactive
                                    </td>
                                    @endif
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.additional-deduction.index') }}">
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