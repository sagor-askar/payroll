@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.create') }} Rules
                </div>
                <div class="panel-body">
                    <form method="POST" id="basic-form" action="{{ route("admin.rules.store") }}" enctype="multipart/form-data">
                        @csrf

                        <div class="col-md-6">
                            <div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
                                <label class="required" for="type">Type</label>
                                <select class="form-control select2" name="type" id="type"  required>
                                       <option value="">Select One</option>
                                        <option value="time">Time</option>
                                         <option value="bonus">Bonus </option>
                                         <option value="promotion">Promotion </option>
                                         <option value="increment">Increment </option>
                                         <option value="salaryAdvance">Salary Advance </option>
                                         <option value="loan">Loan</option>
                                </select>
                                @if($errors->has('type'))
                                    <span class="help-block" role="alert">{{ $errors->first('type') }}</span>
                                @endif
                            </div>

                            <div class="showtimediv" >
                            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                <label class="required" for="name">{{ trans('cruds.user.fields.name') }}</label>
                                <input class="form-control" placeholder="Ex: attendance" type="text" name="name" id="name" value="{{ old('name', '') }}">
                                @if($errors->has('name'))
                                    <span class="help-block" role="alert">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                            <div class="form-group {{ $errors->has('start_time') ? 'has-error' : '' }}">
                                <label class="required" for="start_time">Start Time</label>
                                <input class="form-control" type="time" name="start_time" id="start_time" value="{{ old('start_time') }}">
                                @if($errors->has('start_time'))
                                    <span class="help-block" role="alert">{{ $errors->first('start_time') }}</span>
                                @endif
                            </div>

                            <div class="form-group {{ $errors->has('end_time') ? 'has-error' : '' }}">
                                <label class="required" for="end_time">End Time</label>
                                <input class="form-control " type="time" name="end_time" id="end_time" value="{{ old('end_time') }}">
                                @if($errors->has('end_time'))
                                    <span class="help-block" role="alert">{{ $errors->first('end_time') }}</span>
                                @endif
                            </div>
                            </div>
                            <div class="show_bonus" style="display: none">
                                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                    <label for="name"> Name </label>
                                    <input class="form-control" type="text" name="name" id="name" value="{{ old('name') }}">
                                    @if($errors->has('name'))
                                        <span class="help-block" role="alert">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>

                                <div class="form-group {{ $errors->has('period') ? 'has-error' : '' }}">
                                    <label class="required" for="period"> Period ( In Months)</label>
                                    <input class="form-control" type="number" name="period" id="period" value="{{ old('period') }}">
                                    @if($errors->has('period'))
                                        <span class="help-block" role="alert">{{ $errors->first('period') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <button class="button" type="submit" >
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
@section('scripts')
 <script type="text/javascript">
    $(document).ready(function () {
        $(document).on('change', '#type', function () {
            var name = $(this).val();
            if (name =='time'){
                $(".showtimediv").show();
                $(".show_bonus").hide();
            }else if(name =='bonus'){
                $(".showtimediv").hide();
                $(".show_bonus").show();
            }else if(name =='promotion'){
                $(".showtimediv").hide();
                $(".show_bonus").show();
            }else if(name =='increment'){
                $(".showtimediv").hide();
                $(".show_bonus").show();
            }else if(name =='salaryAdvance'){
                $(".showtimediv").hide();
                $(".show_bonus").show();
            }else if(name =='loan'){
                $(".showtimediv").hide();
                $(".show_bonus").show();
            }

        });
    });
</script>
@endsection
<style>
    .error{
        font-weight: 300;
        color: red;
    }

</style>
