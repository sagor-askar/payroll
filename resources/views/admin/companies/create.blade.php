@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.create') }} {{ trans('cruds.company.title_singular') }}
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route("admin.companies.store") }}" enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-6 col-sm-3">
                            <div class="form-group {{ $errors->has('comp_name') ? 'has-error' : '' }}">
                                <label class="required" for="comp_name">{{ trans('cruds.company.fields.comp_name') }}</label>
                                <input class="form-control" placeholder="Enter Company Name" type="text" name="comp_name" id="comp_name" value="{{ old('comp_name', '') }}" required>
                                @if($errors->has('comp_name'))
                                    <span class="help-block" role="alert">{{ $errors->first('comp_name') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.company.fields.comp_name_helper') }}</span>
                            </div>

                            <div class="form-group {{ $errors->has('comp_address') ? 'has-error' : '' }}">
                                <label class="required" for="comp_address">{{ trans('cruds.company.fields.comp_address') }}</label>
                                <input class="form-control" placeholder="Enter Company Address" type="text" name="comp_address" id="comp_address" value="{{ old('comp_address', '') }}" required>
                                @if($errors->has('comp_address'))
                                    <span class="help-block" role="alert">{{ $errors->first('comp_address') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.company.fields.comp_address_helper') }}</span>
                            </div>
                        </div>


                        <div class="col-md-6 col-sm-3">
                            <div class="form-group {{ $errors->has('contact_no') ? 'has-error' : '' }}">
                                <label for="contact_no">{{ trans('cruds.company.fields.contact_no') }}</label>
                                <input class="form-control" placeholder="Enter Phone Number" type="text" name="contact_no" id="contact_no" value="{{ old('contact_no', '') }}">
                                <input class="form-control" type="hidden" name="user_id"  value="{{ Auth::user()->id }}">
                                @if($errors->has('contact_no'))
                                    <span class="help-block" role="alert">{{ $errors->first('contact_no') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.company.fields.contact_no_helper') }}</span>
                            </div>
                        </div>
                        
                        
                        <div class="col-md-12 col-sm-3">
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