@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.show') }} {{ trans('cruds.leaveType.title') }}
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.leave-types.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.leaveType.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $leaveType->id }}
                                    </td>
                                </tr>
                               
                                <tr>
                                    <th>
                                        {{ trans('cruds.leaveType.fields.company') }}
                                    </th>
                                    <td>
                                        {{ $leaveType->company->comp_name ?? '' }}
                                    </td>
                                </tr>

                                <tr>
                                    <th>
                                        {{ trans('cruds.leaveType.fields.sub_company_id') }}
                                    </th>
                                    <td>
                                        {{ $leaveType->subcompany->sub_company_name ?? '' }}
                                    </td>
                                </tr>
                                
                                <tr>
                                    <th>
                                        {{ trans('cruds.leaveType.fields.leave_name') }}
                                    </th>
                                    <td>
                                        {{ $leaveType->leave_name }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.leave-types.index') }}">
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