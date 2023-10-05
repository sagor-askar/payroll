@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                 Update Training Type
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route("admin.training_type.update", [$training_type->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                    <label  for="name">Name</label>
                                    <input class="form-control" placeholder="Enter name" type="text" name="name" id="name" value="{{ old('name', $training_type->name) }}">
                                    @if($errors->has('name'))
                                        <span class="help-block" role="alert">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="button" type="submit">
                                {{ trans('global.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
