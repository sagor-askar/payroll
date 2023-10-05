@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.show') }} {{ trans('cruds.rank.title') }}
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.ranks.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.rank.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $rank->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <!-- <th>
                                        {{-- {{ trans('cruds.rank.fields.department') }} --}}
                                    </th>
                                    <td>
                                        {{ $rank->department->department_name ?? '' }}
                                    </td> -->

                                    <th>
                                        Company
                                    </th>
                                    <td>
                                        {{ $rank->company->comp_name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.rank.fields.rank') }}
                                    </th>
                                    <td>
                                        {{ $rank->rank }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.ranks.index') }}">
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