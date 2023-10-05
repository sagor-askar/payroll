@extends('layouts.admin')
@section('content')
    <div class="content">

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{ trans('global.show') }} Trainer
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="form-group">
                                <a class="btn btn-default" href="{{ route('admin.trainer.index') }}">
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
                                        {{ $trainer->name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Email
                                    </th>
                                    <td>
                                        {{ $trainer->email ?? '' }}
                                    </td>
                                </tr>

                                <tr>
                                    <th>
                                        Contact Number
                                    </th>
                                    <td>
                                        {{ $trainer->contact_number ?? '' }}
                                    </td>
                                </tr>

                                <tr>
                                    <th>
                                       Address
                                    </th>
                                    <td>
                                        {{ $trainer->address ?? '' }}
                                    </td>
                                </tr>



                                <tr>
                                    <th>
                                        Expertise
                                    </th>
                                    <td>
                                        {{ $trainer->expertise ?? '' }}
                                    </td>
                                </tr>


                                <tr>
                                    <th>
                                        Status
                                    </th>
                                    @if($trainer->status == 1 )
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
                                <a class="btn btn-default" href="{{ route('admin.trainer.index') }}">
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
