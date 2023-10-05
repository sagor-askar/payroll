@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.create') }} Shift
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route("admin.shifts.store") }}" enctype="multipart/form-data">
                        @csrf
                       <div class="col-md-6">
                            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                <label  for="name">Name</label>
                                <input class="form-control" placeholder="Enter Shift Name" type="text" name="name" id="name" value="{{ old('name', '') }}">
                                @if($errors->has('name'))
                                    <span class="help-block" role="alert">{{ $errors->first('name') }}</span>
                                @endif
                            </div>

                           <div class="form-group {{ $errors->has('start_time') ? 'has-error' : '' }}">
                               <label for="start_time">Start_time</label>
                               <input class="form-control" type="time" name="start_time" id="start_time" value="{{ old('start_time') }}">
                               @if($errors->has('start_time'))
                                   <span class="help-block" role="alert">{{ $errors->first('start_time') }}</span>
                               @endif
                           </div>
                           <div class="form-group {{ $errors->has('end_time') ? 'has-error' : '' }}">
                               <label  for="end_time">End Time</label>
                               <input  class="form-control" type="time" name="end_time" id="end_time" value="{{ old('end_time') }}">
                               @if($errors->has('end_time'))
                                   <span class="help-block" role="alert">{{ $errors->first('end_time') }}</span>
                               @endif
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
