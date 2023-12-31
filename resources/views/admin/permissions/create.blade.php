@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.create') }} {{ trans('cruds.permission.title_singular') }}
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route("admin.permissions.store") }}" enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-12">
                            <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                <label class="required" for="title">{{ trans('cruds.permission.fields.title') }}</label>
                                <input class="form-control" type="text" name="title" id="title" value="{{ old('title', '') }}" required>
                                @if($errors->has('title'))
                                    <span class="help-block" role="alert">{{ $errors->first('title') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.permission.fields.title_helper') }}</span>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <button class="button" type="submit">
                                    {{ trans('global.save') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>



        </div>
    </div>
</div>
@endsection