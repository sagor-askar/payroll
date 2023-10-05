<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ trans('panel.site_title') }}</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/select/1.3.0/css/select.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.3/css/AdminLTE.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.3/css/skins/_all-skins.min.css" rel="stylesheet" />
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />
  {{-- FOR TOASTR MESSAGE --}}
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" integrity="sha512-xmGTNt20S0t62wHLmQec2DauG9T+owP9e6VU8GigI0anN7OXLip9i7IwEhelasml2osdxX71XcYm6BQunTQeQg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
     {{-- FOR TOASTR MESSAGE --}}
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('css/steps.css')}}">
    <style>
      .dropdown-menu.notify-drop {
       min-width: 330px;
       background-color: #fff;
       min-height: 360px;
       max-height: 360px;
     }
      .dropdown-menu.notify-drop .notify-drop-title {
       border-bottom: 1px solid #e2e2e2;
       background-color: black;
       padding: 5px 15px 10px 15px;
       color: white;
     }
      .dropdown-menu.notify-drop .drop-content {
       min-height: 280px;
       max-height: 280px;
       overflow-y: scroll;
     }
      .dropdown-menu.notify-drop .drop-content::-webkit-scrollbar-track
     {
       background-color: #F5F5F5;
     }

      .dropdown-menu.notify-drop .drop-content::-webkit-scrollbar
     {
       width: 8px;
       background-color: #F5F5F5;
     }

      .dropdown-menu.notify-drop .drop-content::-webkit-scrollbar-thumb
     {
       background-color: #ccc;
     }
      .dropdown-menu.notify-drop .drop-content > li {
       border-bottom: 1px solid #e2e2e2;
       padding: 10px 0px 5px 0px;
     }
      .dropdown-menu.notify-drop .drop-content > li:nth-child(2n+0) {
       background-color: #fafafa;
     }
      .dropdown-menu.notify-drop .drop-content > li:after {
       content: "";
       clear: both;
       display: block;
     }
      .dropdown-menu.notify-drop .drop-content > li:hover {
       background-color: #fcfcfc;
     }
      .dropdown-menu.notify-drop .drop-content > li:last-child {
       border-bottom: none;
     }
      .dropdown-menu.notify-drop .drop-content > li .notify-img {
       float: left;
       display: inline-block;
       width: 45px;
       height: 45px;
       margin: 0px 0px 8px 0px;
     }
      .dropdown-menu.notify-drop .allRead {
       margin-right: 7px;
     }
      .dropdown-menu.notify-drop .rIcon {
       float: right;
       color: #999;
     }
      .dropdown-menu.notify-drop .rIcon:hover {
       color: #333;
     }
      .dropdown-menu.notify-drop .drop-content > li a {
       font-size: 12px;
       font-weight: normal;
     }
      .dropdown-menu.notify-drop .drop-content > li {
       font-weight: bold;
       font-size: 11px;
     }
      .dropdown-menu.notify-drop .drop-content > li hr {
       margin: 5px 0;
       width: 70%;
       border-color: #e2e2e2;
     }
      .dropdown-menu.notify-drop .drop-content .pd-l0 {
       padding-left: 0;
     }
      .dropdown-menu.notify-drop .drop-content > li p {
       font-size: 11px;
       color: #666;
       font-weight: normal;
       margin: 3px 0;
     }
      .dropdown-menu.notify-drop .drop-content > li p.time {
       font-size: 10px;
       font-weight: 600;
       top: -6px;
       margin: 8px 0px 0px 0px;
       padding: 0px 3px;
       border: 1px solid #e2e2e2;
       position: relative;
       background-image: linear-gradient(#fff,#f2f2f2);
       display: inline-block;
       border-radius: 2px;
       color: #B97745;
     }
      .dropdown-menu.notify-drop .drop-content > li p.time:hover {
       background-image: linear-gradient(#fff,#fff);
     }
      .dropdown-menu.notify-drop .notify-drop-footer {
       border-top: 1px solid #e2e2e2;
       bottom: 0;
       position: relative;
       padding: 8px 15px;
       background-color: black;
     }
      .dropdown-menu.notify-drop .notify-drop-footer a {
       color: white;
       text-decoration: none;
     }
      .dropdown-menu.notify-drop .notify-drop-footer a:hover {
       color: white;
     }

   </style>
    @yield('styles')
</head>

<body class="sidebar-mini skin-purple" style="height: auto; min-height: 100%;">
    <div class="wrapper" style="height: auto; min-height: 100%;">
        <header class="main-header">
            <a href="#" class="logo">
                @foreach(Auth::user()->roles as $key => $item)
                    <span class="logo-mini"><b>{{ Auth::user()->name }}({{ $item->title }})</b></span>
                    <span class="logo-lg"><b>{{ Auth::user()->name }}({{ $item->title }}) </b></span>
                @endforeach

            </a>

            <nav class="navbar navbar-static-top">
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">{{ trans('global.toggleNavigation') }}</span>
                </a>
                <ul class="nav navbar-nav navbar-right">
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="float:right"><i class="fa fa-bell-o fa-lg"></i> <span class="badge badge-light">{{ Auth::user()->unreadNotifications->count() }}</span></a>
                    <ul class="dropdown-menu notify-drop">
                      <div class="notify-drop-title bg-dark">
                        <div class="row">
                          <div class="col-md-6 col-sm-6 col-xs-6">Notification (<b>{{ Auth::user()->unreadNotifications->count() }}</b>)</div>
                          <div class="col-md-6 col-sm-6 col-xs-6 text-right"><a href="" class="rIcon allRead" data-tooltip="tooltip" data-placement="bottom" title="tümü okundu."><i class="fa fa-dot-circle-o"></i></a></div>
                        </div>
                      </div>
                      <!-- end notify title -->
                      <!-- notify content -->
                      <div class="drop-content">
                        @foreach(Auth::user()->unreadNotifications as $notification)
                          <li>
                            <div class="col-md-9 col-sm-9 col-xs-9 pd-l0">
                              @isset($notification->data['holiday_name'])
                              <strong class="text-info">{{ $notification->data['holiday_name'] ?? ''}}</strong><br>
                              <small class="text-warning">From {{ $notification->data['from_holiday'] ?? '' }}</small>
                              <small class="text-warning">To {{ $notification->data['to_holiday'] ?? '' }}</small>
                              <small class="text-warning">({{$notification->data['number_of_days'] ?? '' }} days)</small> <br>  
                              @endisset
                              @isset ($notification->data['notice_title'])
                              <a href="{{ route('admin.noticeboards.show', $notification->data['id']) }}"><strong class="text-info">{{ $notification->data['notice_title'] ?? ''}}</strong><br></a>
                              <small class="text-warning">{{ $notification->data['notice_date'] ?? '' }}</small><br>
                              @endisset
                                    
                              <small class="text-warning">{{ $notification->created_at->diffForHumans() ?? ''}}</small> <br>            
                                <a href="{{ route('markasread',$notification->id) }}">
                                  <p class="time"> Mark as read</p>
                                </a>
                            </div>
                          </li>
                        @endforeach
                      </div>
                      <div class="notify-drop-footer text-center">
                        <a href="#"><i class="fa fa-eye"></i> See All</a>
                      </div>
                    </ul>
                  </li>
                </ul>



                @if(count(config('panel.available_languages', [])) > 1)
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <li class="dropdown notifications-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    {{ strtoupper(app()->getLocale()) }}
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <ul class="menu">
                                            @foreach(config('panel.available_languages') as $langLocale => $langName)
                                                <li>
                                                    <a href="{{ url()->current() }}?change_language={{ $langLocale }}">{{ strtoupper($langLocale) }} ({{ $langName }})</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                @endif


            </nav>
        </header>

        @include('partials.menu')

        <div class="content-wrapper" style="min-height: 960px;">
            {{-- @if(session('message'))
                <div class="row" style='padding:20px 20px 0 20px;'>
                    <div class="col-lg-12">
                        <div class="alert alert-success" role="alert">{{ session('message') }}</div>
                    </div>
                </div>
            @endif --}}
            @if($errors->count() > 0)
                <div class="row" style='padding:20px 20px 0 20px;'>
                    <div class="col-lg-12">
                        <div class="alert alert-danger">
                            <ul class="list-unstyled">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
            @yield('content')
        </div>
        <footer class="main-footer text-center">
            <strong>{{ trans('panel.site_title') }} &copy;</strong> {{ trans('global.allRightsReserved') }}
        </footer>

        <form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.3/js/adminlte.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.19/js/dataTables.bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.3.0/js/dataTables.select.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.flash.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/16.0.0/classic/ckeditor.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js" integrity="sha512-9UR1ynHntZdqHnwXKTaOm1s6V9fExqejKvg5XMawEMToW4sSw+3jtLrYfZPijvnwnnE8Uol1O9BcAskoxgec+g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/jqueryblockUI.js') }}"></script>
    {{-- FOR TOASTR MESSAGE --}}
   <script>
      @if(Session::has('message'))
      toastr.options =
      {
        "closeButton" : true,
        "progressBar" : true
      }
          toastr.success("{{ session('message') }}");
      @endif

      @if(Session::has('error'))
      toastr.options =
      {
        "closeButton" : true,
        "progressBar" : true
      }
          toastr.error("{{ session('error') }}");
      @endif

      @if(Session::has('info'))
      toastr.options =
      {
        "closeButton" : true,
        "progressBar" : true
      }
          toastr.info("{{ session('info') }}");
      @endif

      @if(Session::has('warning'))
      toastr.options =
      {
        "closeButton" : true,
        "progressBar" : true
      }
          toastr.warning("{{ session('warning') }}");
      @endif
    </script>
     {{-- FOR TOASTR MESSAGE --}}
    <script>
        $(function() {
  let copyButtonTrans = '{{ trans('global.datatables.copy') }}'
  let csvButtonTrans = '{{ trans('global.datatables.csv') }}'
  let excelButtonTrans = '{{ trans('global.datatables.excel') }}'
  let pdfButtonTrans = '{{ trans('global.datatables.pdf') }}'
  let printButtonTrans = '{{ trans('global.datatables.print') }}'
  let colvisButtonTrans = '{{ trans('global.datatables.colvis') }}'
  let selectAllButtonTrans = '{{ trans('global.select_all') }}'
  let selectNoneButtonTrans = '{{ trans('global.deselect_all') }}'

  let languages = {
    'en': 'https://cdn.datatables.net/plug-ins/1.10.19/i18n/English.json'
  };

  $.extend(true, $.fn.dataTable.Buttons.defaults.dom.button, { className: 'btn' })
  $.extend(true, $.fn.dataTable.defaults, {
    language: {
      url: languages['{{ app()->getLocale() }}']
    },
    columnDefs: [{
        orderable: false,
        className: 'select-checkbox',
        targets: 0
    }, {
        orderable: false,
        searchable: false,
        targets: -1
    }],
    select: {
      style:    'multi+shift',
      selector: 'td:first-child'
    },
    order: [],
    scrollX: true,
    pageLength: 100,
    paging:   false,
    dom: 'lBfrtip<"actions">',
    buttons: [
      {
        extend: 'selectAll',
        className: 'btn-primary',
        text: selectAllButtonTrans,
        exportOptions: {
          columns: ':visible'
        },
        action: function(e, dt) {
          e.preventDefault()
          dt.rows().deselect();
          dt.rows({ search: 'applied' }).select();
        }
      },
      {
        extend: 'selectNone',
        className: 'btn-primary',
        text: selectNoneButtonTrans,
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'copy',
        className: 'btn-default',
        text: copyButtonTrans,
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'csv',
        className: 'btn-default',
        text: csvButtonTrans,
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'excel',
        className: 'btn-default',
        text: excelButtonTrans,
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'pdf',
        className: 'btn-default',
        text: pdfButtonTrans,
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'print',
        className: 'btn-default',
        text: printButtonTrans,
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'colvis',
        className: 'btn-default',
        text: colvisButtonTrans,
        exportOptions: {
          columns: ':visible'
        }
      }
    ]
  });

  $.fn.dataTable.ext.classes.sPageButton = '';
});

    </script>
    @yield('scripts')
</body>

</html>
