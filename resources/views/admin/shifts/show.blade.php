@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.show') }} Shift
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.branches.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>

                                <tr>
                                    <th>
                                       Shift Name
                                    </th>
                                    <td>
                                        {{ $shift->name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                      Start Time
                                    </th>
                                    <td>
                                        {{ $shift->start_time ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        End Time
                                    </th>
                                    <td>
                                        {{ $shift->end_time ?? '' }}
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.branches.index') }}">
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
