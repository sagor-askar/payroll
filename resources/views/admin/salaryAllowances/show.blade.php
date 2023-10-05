@extends('layouts.admin')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.show') }} {{ trans('cruds.salaryAllowance.title') }}
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.salary-allowances.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.salaryAllowance.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $salaryAllowance->id }}
                                    </td>
                                </tr>
                              

                                <tr>
                                    <th>
                                        {{ trans('cruds.salaryAllowance.fields.company') }}
                                    </th>
                                    <td>
                                        {{ $salaryAllowance->company->comp_name ?? '' }}
                                    </td>
                                </tr>
                               
                                <tr>
                                    <th>
                                        {{ trans('cruds.salaryAllowance.fields.allowance_name') }}
                                    </th>
                                    <td>
                                        {{ $salaryAllowance->allowance_name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.salaryAllowance.fields.percentage') }}
                                    </th>
                                    <td>
                                        {{ $salaryAllowance->percentage }} %
                                    </td>
                                </tr>
                                {{-- <tr>
                                    <th>
                                        {{ trans('cruds.salaryAllowance.fields.percentage_salary') }}
                                    </th>
                                    <td>
                                        {{ $salaryAllowance->percentage_salary }}
                                    </td>
                                </tr> --}}

                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.salary-allowances.index') }}">
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
