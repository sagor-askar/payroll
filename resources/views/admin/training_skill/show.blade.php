@extends('layouts.admin')
@section('content')
    <div class="content">

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{ trans('global.show') }} Training Skill
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="form-group">
                                <a class="btn btn-default" href="{{ route('admin.training_skill.index') }}">
                                    {{ trans('global.back_to_list') }}
                                </a>
                            </div>
                            <table class="table table-bordered table-striped">
                                <tbody>

                                <tr>
                                    <th>
                                        Name
                                    </th>
                                    <td>
                                        {{ $training_skill->name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Status
                                    </th>
                                    @if($training_skill->status == 1 )
                                        <td style="color: green">
                                            Active
                                        </td>
                                    @else
                                        <td style="color: red">
                                            InActive
                                        </td>
                                    @endif
                                </tr>

                                </tbody>
                            </table>
                            <div class="form-group">
                                <a class="btn btn-default" href="{{ route('admin.training_skill.index') }}">
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
