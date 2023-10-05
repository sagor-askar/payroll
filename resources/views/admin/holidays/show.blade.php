@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.show') }} {{ trans('cruds.holiday.title') }}
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.holidays.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.holiday.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $holiday->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.holiday.fields.department') }}
                                    </th>
                                    <td>
                                        {{ $holiday->department->department_name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.holiday.fields.company') }}
                                    </th>
                                    <td>
                                        {{ $holiday->company->comp_name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.holiday.fields.holiday_name') }}
                                    </th>
                                    <td>
                                        {{ $holiday->holiday_name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.holiday.fields.from_holiday') }}
                                    </th>
                                    <td>
                                        {{ $holiday->from_holiday }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.holiday.fields.to_holiday') }}
                                    </th>
                                    <td>
                                        {{ $holiday->to_holiday }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.holiday.fields.number_of_days') }}
                                    </th>
                                    <td>
                                        {{ $holiday->number_of_days }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.holidays.index') }}">
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