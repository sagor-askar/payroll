@extends('layouts.app')
@section('content')
<section class="material-half-bg">
    <div class="cover"></div>
</section>
<section class="login-content">
    <div class="logo">
        @php
              $setting = \App\Models\Settings::first();
        @endphp
        <h1>{{ $setting->company_title }}</h1>
    </div>
    <div class="login-box">
        @if(session('message'))
        <p class="alert alert-info">
            {{ session('message') }}
        </p>
        @endif
        @if(session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <form class="login-form" method="POST" action="{{ route('login') }}">
            @csrf
            <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>SIGN IN</h3>
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label class="control-label">Email</label>
                <input class="form-control" type="email" name="email" placeholder="Email" required autocomplete="email" autofocus value="{{ old('email', null) }}">
                @if($errors->has('email'))
                <p class="help-block">
                    {{ $errors->first('email') }}
                </p>
                @endif
            </div>
            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <label class="control-label">Password</label>
                <input class="form-control" type="password" name="password" placeholder="Password">
                @if($errors->has('password'))
                    <p class="help-block">
                        {{ $errors->first('password') }}
                    </p>
                @endif
            </div>
            <div class="form-group">
                <div class="utility">
                    <div class="animated-checkbox iCheck">
                        <label>
                            <input type="checkbox" name="remember"><span class="label-text">Stay Signed in</span>
                        </label>
                    </div>
                    {{-- <a href="{{ route('password.request') }}">
                        {{ trans('global.forgot_password') }}
                    </a><br> --}}
                    <p class="semibold-text mb-2"><a href="#" data-toggle="flip">Forgot Password ?</a></p>
                </div>
            </div>
            <div class="form-group btn-container">
                <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-sign-in fa-lg fa-fw"></i>SIGN IN</button>
            </div>
        </form>
        <form class="forget-form" method="POST" action="{{ route('password.email') }}">
            @csrf
            <h3 class="login-head"><i class="fa fa-lg fa-fw fa-lock"></i>Forgot Password ?</h3>
            
            <div class="form-group">
                <label class="control-label">EMAIL</label>
                <input id="email" type="email" class="form-control" name="email" required autocomplete="email" autofocus placeholder="{{ trans('global.login_email') }}" value="{{ old('email') }}">
                @if($errors->has('email'))
                    <span class="help-block" role="alert">
                        {{ $errors->first('email') }}
                    </span>
                @endif
            </div>
            <div class="form-group btn-container">
                <button class="btn btn-primary btn-block"><i class="fa fa-unlock fa-lg fa-fw"></i> {{ trans('global.send_password') }}</button>
            </div>
            <div class="form-group mt-3">
                <p class="semibold-text mb-0"><a href="#" data-toggle="flip"><i class="fa fa-angle-left fa-fw"></i> Back
                        to Login</a></p>
            </div>
           
        </form>
    </div>
</section>

@endsection

@section('scripts')
<script>
    $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
@endsection