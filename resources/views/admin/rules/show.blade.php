@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.show') }} Rules
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.rules.index') }}">
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
                                        {{ $rule->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                       Company
                                    </th>
                                    <td>
                                        {{ $rule->company->comp_name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Type
                                    </th>
                                    <td>
                                        {{ $rule->type }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Name
                                    </th>
                                    <td>
                                        {{ $rule->name }}
                                    </td>
                                </tr>
                                @if($rule->type == 'time')
                                <tr>
                                    <th>
                                        Start Time
                                    </th>
                                    <td>
                                        {{ $rule->start_time }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        End Time
                                    </th>
                                    <td>
                                        {{ $rule->end_time }}
                                    </td>
                                </tr>
                             @else
                                    <tr>
                                        <th>
                                           Period
                                        </th>
                                        <td>
                                            {{ $rule->period ?? '' }} Months
                                        </td>
                                    </tr>
                            @endif
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.rules.index') }}">
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
