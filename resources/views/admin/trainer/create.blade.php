@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.create') }} Trainer
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route("admin.trainer.store") }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                    <label  for="name">Name</label>
                                    <input class="form-control" placeholder="Enter name" type="text" name="name" id="name" value="{{ old('name', '') }}">
                                    @if($errors->has('name'))
                                        <span class="help-block" role="alert">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>

                                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                                    <label  for="email">Email</label>
                                    <input class="form-control" placeholder="Enter Email" type="email" name="email" id="email" value="{{ old('email', '') }}">
                                    @if($errors->has('email'))
                                        <span class="help-block" role="alert">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>

                                <div class="form-group {{ $errors->has('contact_number') ? 'has-error' : '' }}">
                                    <label  for="contact_number">Contact Number</label>
                                    <input class="form-control" placeholder="Enter contact number" type="text" name="contact_number" id="contact_number" value="{{ old('contact_number', '') }}">
                                    @if($errors->has('contact_number'))
                                        <span class="help-block" role="alert">{{ $errors->first('contact_number') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">

                                <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                                    <label  for="address">Address</label>
                                    <input class="form-control" placeholder="Enter address" type="text" name="address" id="address" value="{{ old('address', '') }}">
                                    @if($errors->has('address'))
                                        <span class="help-block" role="alert">{{ $errors->first('address') }}</span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label  for=""> Expertise</label>
                                    <textarea class="form-control" type="text" placeholder="Write Here.." name="expertise" id="expertise"></textarea>
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

