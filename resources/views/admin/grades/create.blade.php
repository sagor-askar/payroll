@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.create') }} {{ trans('cruds.grade.title_singular') }}
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route("admin.grades.store") }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="col-md-6">
                            <div class="form-group {{ $errors->has('company') ? 'has-error' : '' }}">
                                <label class="required" for="company_id">{{ trans('cruds.department.fields.company') }}</label>
                                <select class="form-control select2" name="company_id" id="company_id" required>
                                    {{-- @foreach($companies as $id => $entry) --}}
                                    <option value="{{ $companies->id }}" {{ old('company_id') == $companies->id ? 'selected' : '' }}>{{ $companies->comp_name }}</option>
                                    {{-- @endforeach --}}
                                </select>
                                @if($errors->has('company'))
                                    <span class="help-block" role="alert">{{ $errors->first('company') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.department.fields.company_helper') }}</span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group {{ $errors->has('grade') ? 'has-error' : '' }}">
                                <label class="required" for="grade">{{ trans('cruds.grade.fields.grade') }}</label>
                                <input class="form-control" placeholder="Enter Grade Name" type="text" name="grade" id="grade" value="{{ old('grade', '') }}" required>
                                @if($errors->has('grade'))
                                    <span class="help-block" role="alert">{{ $errors->first('grade') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.grade.fields.grade_helper') }}</span>
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