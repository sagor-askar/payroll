@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.edit') }} {{ trans('cruds.rank.title_singular') }}
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route("admin.ranks.update", [$rank->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="col-md-6">
                            <div class="form-group {{ $errors->has('company') ? 'has-error' : '' }}">
                                <label class="required" for="company_id">{{ trans('cruds.department.fields.company') }}</label>
                                <select class="form-control select2" name="company_id" id="company_id" required>
                                    {{-- @foreach($companies as $id => $entry) --}}
                                        <option value="{{ $companies->id }}" {{ (old('company_id') ? old('company_id') : $rank->company->id ?? '') == $companies->id ? 'selected' : '' }}>{{ $companies->comp_name }}</option>
                                    {{-- @endforeach --}}
                                </select>
                                @if($errors->has('company'))
                                    <span class="help-block" role="alert">{{ $errors->first('company') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.department.fields.company_helper') }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group {{ $errors->has('rank') ? 'has-error' : '' }}">
                                <label class="required" for="rank">{{ trans('cruds.rank.fields.rank') }}</label>
                                <input class="form-control" type="text" name="rank" id="rank" value="{{ old('rank', $rank->rank) }}" required>
                                @if($errors->has('rank'))
                                    <span class="help-block" role="alert">{{ $errors->first('rank') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.rank.fields.rank_helper') }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
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