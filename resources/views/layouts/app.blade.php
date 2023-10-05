<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ trans('panel.site_title') }}</title>
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/login.css') }}">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <body>
    @yield('content')

    <!-- Essential javascripts for application to work-->
    <script src="{{ asset('js/login/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/login/popper.min.js') }}"></script>
    <script src="{{ asset('js/login/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/login/main.js') }}"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="{{ asset('js/login/plugins/pace.min.js') }}"></script>
    <script type="text/javascript">
      // Login Page Flipbox control
      $('.login-content [data-toggle="flip"]').click(function() {
      	$('.login-box').toggleClass('flipped');
      	return false;
      });
    </script>
     @yield('scripts')
  </body>
</html>
