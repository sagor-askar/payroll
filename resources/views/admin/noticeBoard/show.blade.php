@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.show') }} Notice Board
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.noticeboards.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        Serial No
                                    </th>
                                    <td>
                                        {{ $noticeBoard->id }}
                                    </td>
                                </tr>
                               
                                <tr>
                                    <th>
                                       Notice Title
                                    </th>
                                    <td>
                                        {{ $noticeBoard->notice_title ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                       Notice Date
                                    </th>
                                    <td>
                                        {{ $noticeBoard->notice_date ?? '' }}
                                    </td>
                                </tr>

                                <tr>
                                    <th>
                                       Description
                                    </th>
                                    <td>
                                        {!! $noticeBoard->description ?? '' !!}
                                    </td>
                                </tr>                                
                                <tr>
                                    <th>
                                       Department
                                    </th>
                                    <td>
                                        {{ $noticeBoard->department_id==NUll ? 'All' : $noticeBoard->department->department_name ?? '' }}
                                        
                                    </td>
                                </tr>                                
                                <tr>
                                    <th>
                                       Employee
                                    </th>
                                    <td>
                                        {{ $noticeBoard->employee_id==NUll ? 'All' : $noticeBoard->employee->first_name ?? '' }}
                                        
                                    </td>
                                </tr>                                
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.noticeboards.index') }}">
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