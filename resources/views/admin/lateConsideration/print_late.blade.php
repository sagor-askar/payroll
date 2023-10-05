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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    {{-- FOR TOASTR MESSAGE --}}
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('css/steps.css')}}">
    @yield('styles')
</head>

<body class="sidebar-mini skin-purple" style="height: auto; min-height: 100%;">
<div  style="height: auto; min-height: 100%;">
    <div style="min-height: 960px;">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
        <div class="content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="container bootdey" style="width: auto;">
                        <div class="row invoice row-printable">
                            <div class="col-md-10">
                                <!-- col-lg-12 start here -->
                                <div class="panel panel-default plain" id="dash_0" style="margin-left: 20%;">
                                    <!-- Start .panel -->
                                    <div class="panel-body" style="border: none;">
                                        <div class="row" >
                                            <!-- Start .row -->
                                            <div class="col-lg-6">
                                                <!-- col-lg-6 start here -->
                                                <div class="invoice-logo">
                                                    <img width="100" src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Invoice logo">
                                                </div>
                                            </div>
                                            <!-- col-lg-6 end here -->
                                            <div class="col-lg-6">
                                                <!-- col-lg-6 start here -->
                                                <div class="invoice-from">
                                                    <ul class="list-unstyled text-right">
                                                        <li><h3><b>Polock Group</b></h3></li>
                                                        <li>one</li>
                                                        <li>two</li>
                                                        <li>three</li>
                                                        <li>thsdsdsree</li>

                                                    </ul>
                                                </div>
                                            </div>
                                            <!-- col-lg-6 end here -->
                                            <div class="col-lg-12"">
                                            <!-- col-lg-12 start here -->
                                            <div class="panel-heading row">
                                                <div style="float: left;">
                                                    <h4 style="color: #605CA8;"><b>Leave Application Form</b></h4>
                                                </div>

                                                <div class="panel-heading" style="float: right;margin-top:-8px;">
                                                    <h4 style="color: #605CA8;" ><b>Date : </b></h4>
                                                </div>
                                            </div>

                                            <div class="invoice-details mt25">
                                                <div class="well" style="background-color: white; border: none;">
                                                    <table class="table table-bordered">
                                                        <tbody>
                                                        <tr>
                                                            <td><b>Employee Name : </b>....</td>
                                                            <td><b>Employee ID : </b>....</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Designtation : </b>....</td>
                                                            <td><b>Department : </b>....</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Leave From : </b>....</td>
                                                            <td><b>To : </b>....</td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <b>Leave Type :</b>....
                                                            </td>
                                                            <td>
                                                                <b>No. of Days :</b>....
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>

                                                    <!-- resone -->
                                                    <div class="row">
                                                        <div class="col-8 col-md-4" style="height: 150px; width: auto; margin-left: 10px;">
                                                            <b>Reason:</b>.....

                                                        </div>
                                                    </div>
                                                    <!-- approved by -->
                                                    <div class="row">
                                                        <div class="col-6 col-md-4">
                                                            <p>...................................</p>
                                                            <b>Employee Signature: </b>
                                                        </div>
                                                        <div class="col-6 col-md-4"></div>
                                                        <div class="col-6 col-md-4">
                                                            <p>...................................</p>
                                                            <b>Approved By :</b> </div>
                                                    </div>

                                                    <table>
                                                        <tbody>
                                                        <tr>
                                                            <td>............</td>
                                                            <td>............</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Employee Signature</td>
                                                            <td>Approved By</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                    <br>
                                                </div>
                                            </div>

                                            <div class="invoice-footer mt25">
                                                <p class="text-center">Generated By - <a href="#"> Polock Group</a></p>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>
                </div>`

            </div>
        </div>
    </div>
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

<script src="{{ asset('js/main.js') }}"></script>


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
</body>

</html>









