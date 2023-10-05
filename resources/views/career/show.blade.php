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

    .dropdown-menu.notify-drop .drop-content::-webkit-scrollbar-track {
      background-color: #F5F5F5;
    }

    .dropdown-menu.notify-drop .drop-content::-webkit-scrollbar {
      width: 8px;
      background-color: #F5F5F5;
    }

    .dropdown-menu.notify-drop .drop-content::-webkit-scrollbar-thumb {
      background-color: #ccc;
    }

    .dropdown-menu.notify-drop .drop-content>li {
      border-bottom: 1px solid #e2e2e2;
      padding: 10px 0px 5px 0px;
    }

    .dropdown-menu.notify-drop .drop-content>li:nth-child(2n+0) {
      background-color: #fafafa;
    }

    .dropdown-menu.notify-drop .drop-content>li:after {
      content: "";
      clear: both;
      display: block;
    }

    .dropdown-menu.notify-drop .drop-content>li:hover {
      background-color: #fcfcfc;
    }

    .dropdown-menu.notify-drop .drop-content>li:last-child {
      border-bottom: none;
    }

    .dropdown-menu.notify-drop .drop-content>li .notify-img {
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

    .dropdown-menu.notify-drop .drop-content>li a {
      font-size: 12px;
      font-weight: normal;
    }

    .dropdown-menu.notify-drop .drop-content>li {
      font-weight: bold;
      font-size: 11px;
    }

    .dropdown-menu.notify-drop .drop-content>li hr {
      margin: 5px 0;
      width: 70%;
      border-color: #e2e2e2;
    }

    .dropdown-menu.notify-drop .drop-content .pd-l0 {
      padding-left: 0;
    }

    .dropdown-menu.notify-drop .drop-content>li p {
      font-size: 11px;
      color: #666;
      font-weight: normal;
      margin: 3px 0;
    }

    .dropdown-menu.notify-drop .drop-content>li p.time {
      font-size: 10px;
      font-weight: 600;
      top: -6px;
      margin: 8px 0px 0px 0px;
      padding: 0px 3px;
      border: 1px solid #e2e2e2;
      position: relative;
      background-image: linear-gradient(#fff, #f2f2f2);
      display: inline-block;
      border-radius: 2px;
      color: #B97745;
    }

    .dropdown-menu.notify-drop .drop-content>li p.time:hover {
      background-image: linear-gradient(#fff, #fff);
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

  <div class="content">
    <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            Job Description
          </div>
          <div class="panel-body">
            <div class="form-group">
              <div class="form-group">

                <div style="float: right">
                  <input type="button" id="btn" class="button" value="Apply for this Job">
                </div>
              </div>

              <div class="row">
                <div class="col-md-4">
                  <table class="table table-bordered table-striped">
                    <tbody>
                    
                      <tr>
                        <th>
                          Job Title
                        </th>
                        <td>
                          {{ $jobsDetails->job_title }}
                        </td>
                      </tr>
                      <tr>
                        <th>
                          Department
                        </th>
                        <td>
                          {{ $jobsDetails->department->department_name }}
                        </td>
                      </tr>
                      <tr>
                        <th>
                          Job Type
                        </th>
                        
                          @if($jobsDetails->job_type == 0)
                          <td>Internship</td>
                          @elseif($jobsDetails->job_type == 1)
                          <td>Parttime</td>
                          @elseif($jobsDetails->job_type == 2)
                          <td>Fulltime</td>
                          @else
                          <td>Contactual</td>
                          @endif
                        
                      </tr>

                      <tr>
                        <th>
                          No Of Position
                        </th>
                        <td>
                          {{ $jobsDetails->no_of_positions }}
                        </td>
                      </tr>
                      <tr>
                        <th>
                          Skills
                        </th>
                        <td>
                          {{ $jobsDetails->skills }}
                        </td>
                      </tr>
                      <tr>
                        <th>
                          Office Time
                        </th>
                        <td>
                          {{ $jobsDetails->office_time }}
                        </td>
                      </tr>
                      <tr>
                        <th>
                          Salary Range
                        </th>
                        <td>
                          {{ $jobsDetails->salary_range }} Tk. (Per Month)
                        </td>
                      </tr>
                      <tr>
                        <th>
                          Office Location
                        </th>
                        <td>
                          {{ $jobsDetails->location }}
                        </td>
                      </tr>
                      <tr>
                        <th>
                          Deadline
                        </th>
                        <td style="color: red">
                          <strong>{{ $jobsDetails->end_date }}</strong>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                  <div class="col-md-8">
                    <div>
                      <div>
                        <h4> Job Requirement</h4>
                      </div>
                      <hr>
                      <div>
                        <p style="text-align: justify;">  {!! $jobsDetails->job_requirement !!}   </p>
                      </div>
                    </div>
                    <br>

                    <div>
                      <div>
                        <h4> Job Description</h4>
                      </div>
                      <hr>
                      <div>
                        <p style="text-align: justify;"> {!! $jobsDetails->job_description !!}  </p>
                      </div>
                    </div>
                  </div>
              </div>

              <br>
              <br>

              <!-- create job application form -->
              
                <div class="panel panel-default" id="Create" style="display:none">
                  <div class="panel-heading text-center">
                    <strong>Apply to Us</strong>
                  </div>
                  <div class="panel-body">
                    <form method="POST" action="{{ route("admin.jobs.jobApplyStore") }}" enctype="multipart/form-data">
                    @csrf
                      <div class="row" >
                        <div class=" col-md-6">

                          <div class="form-group">
                            <label class="required" for="job_title"> Full Name</label>
                              <input type="hidden" name="job_id"  value="{{ $jobsDetails->id }}">
                              <input class="form-control" type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Your Name" required>
                              @if($errors->has('name'))
                                <span class="help-block" role="alert">{{ $errors->first('name') }}</span>
                              @endif
                          </div>

                          @if(in_array('gender', $askarray))
                              <div class="form-group">
                                  <label class="required" for="gender"> Gender</label>
                                  <select class="form-control" name="gender" id="gender" required>
                                      <option value="">Select One</option>
                                          <option value="Male">Male</option>
                                          <option value="Female">Female</option>
                                  </select>
                                  @if($errors->has('gender'))
                                      <span class="help-block" role="alert">{{ $errors->first('gender') }}</span>
                                  @endif
                              </div>
                          @endif

                          <div class="form-group">
                              <label class="required" for="apply_date">Date of Apply</label>
                              
                              <input class="form-control date" type="text" name="apply_date" id="apply_date" value="{{ date('d-m-Y') }}" readonly required>
                              @if($errors->has('apply_date'))
                                  <span class="help-block" role="alert">{{ $errors->first('apply_date') }}</span>
                              @endif
                          </div>

                          @if(in_array('dob', $askarray))
                              <div class="form-group">
                                  <label class="required" for="dob"> Date Of Birth</label>
                                  <input class="form-control date" type="text" name="dob" id="dob" value="{{ old('dob') }}" placeholder="Date of Birth" required>
                                  @if($errors->has('dob'))
                                      <span class="help-block" role="alert">{{ $errors->first('dob') }}</span>
                                  @endif
                              </div>
                          @endif

                          @if(in_array('image', $showOptionArray))
                              <div class="form-group">
                                  <label for="image"> Image <sup>Only .jpeg, .jpg, .png files are accepted</sup></label>
                                  <input class="form-control" type="file" name="image" id="image" value="{{ old('image') }}" accept=".jpg,.jpeg,.png">
                                  @if($errors->has('image'))
                                      <span class="help-block" role="alert">{{ $errors->first('image') }}</span>
                                  @endif
                              </div>
                          @endif
                        </div>

                        <div class=" col-md-6">
                          <div class="form-group">
                              <label class="required" for="job_title"> Email</label>
                              <input class="form-control" type="email" name="email" id="email" value="{{ old('email') }}" placeholder="Your Email" required>
                              @if($errors->has('email'))
                                  <span class="help-block" role="alert">{{ $errors->first('email') }}</span>
                              @endif
                          </div>
                          <div class="form-group">
                              <label class="required" for="job_title"> Phone</label>
                              <input class="form-control" type="text" name="phone" id="phone" value="{{ old('phone') }}" placeholder="Your Email" required>
                              @if($errors->has('phone'))
                                  <span class="help-block" role="alert">{{ $errors->first('phone') }}</span>
                              @endif
                          </div>

                          @if(in_array('resume', $showOptionArray))
                              <div class="form-group">
                                  <label class="required" for="resume"> Resume <sup>Only .pdf & .docs files are accepted</sup></label>
                                  <input class="form-control" type="file" name="resume" id="resume" value="{{ old('resume') }}" accept=".pdf,.docx" required>
                                  @if($errors->has('gender'))
                                      <span class="help-block" role="alert">{{ $errors->first('gender') }}</span>
                                  @endif
                              </div>
                          @endif


                          @if(in_array('cover_letter', $showOptionArray))
                              <div class="form-group">
                                  <label for="cover_letter"> Cover Letter <sup>Only .pdf & .docs files are accepted</sup></label>
                                  <input class="form-control" type="file" name="cover_letter" id="cover_letter" value="{{ old('cover_letter') }}" accept=".pdf,.docx">
                                  @if($errors->has('cover_letter'))
                                      <span class="help-block" role="alert">{{ $errors->first('cover_letter') }}</span>
                                  @endif
                              </div>
                          @endif




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
      </div>
    </div>
  </div>



  @section('scripts')

  <script>
    ClassicEditor
      .create(document.querySelector('#descriptionstyle'))
      .catch(error => {
        console.log(error);
      });
  </script>

  <script>
    ClassicEditor
      .create(document.querySelector('#requirementstyle'))
      .catch(error => {
        console.log(error);
      });
  </script>

  <script>
    function rejectFunction() {
      if (!confirm("Are You Sure to Reject ?"))
        event.preventDefault();
    }
  </script>

  <script>
    function approveFunction() {
      if (!confirm("You are going to Approve !"))
        event.preventDefault();
    }
  </script>

  <script>
    function cancelFunction() {
      if (confirm('{{ trans('
          global.areYouSure ') }}')) {
        $.ajax({
            headers: {
              'x-csrf-token': _token
            },
            method: 'POST',
            url: config.url,
            data: {
              ids: ids,
              _method: 'DELETE'
            }
          })
          .done(function() {
            location.reload()
          })
      }
    }
  </script>
  <script type="text/javascript">
    $(document).ready(function() {
      $('#btn').click(function() {
        $('#Create').animate({
          height: 'show'
        }, 1500, function() {});
      });
    });
  </script>



  @endsection

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


  {{-- FOR TOASTR MESSAGE --}}
  <script>
    @if(Session::has('message'))
    toastr.options = {
      "closeButton": true,
      "progressBar": true
    }
    toastr.success("{{ session('message') }}");
    @endif

    @if(Session::has('error'))
    toastr.options = {
      "closeButton": true,
      "progressBar": true
    }
    toastr.error("{{ session('error') }}");
    @endif

    @if(Session::has('info'))
    toastr.options = {
      "closeButton": true,
      "progressBar": true
    }
    toastr.info("{{ session('info') }}");
    @endif

    @if(Session::has('warning'))
    toastr.options = {
      "closeButton": true,
      "progressBar": true
    }
    toastr.warning("{{ session('warning') }}");
    @endif
  </script>
  {{-- FOR TOASTR MESSAGE --}}
  <script>
    $(function() {
      let copyButtonTrans = '{{ trans('
      global.datatables.copy ') }}'
      let csvButtonTrans = '{{ trans('
      global.datatables.csv ') }}'
      let excelButtonTrans = '{{ trans('
      global.datatables.excel ') }}'
      let pdfButtonTrans = '{{ trans('
      global.datatables.pdf ') }}'
      let printButtonTrans = '{{ trans('
      global.datatables.print ') }}'
      let colvisButtonTrans = '{{ trans('
      global.datatables.colvis ') }}'
      let selectAllButtonTrans = '{{ trans('
      global.select_all ') }}'
      let selectNoneButtonTrans = '{{ trans('
      global.deselect_all ') }}'

      let languages = {
        'en': 'https://cdn.datatables.net/plug-ins/1.10.19/i18n/English.json'
      };

      $.extend(true, $.fn.dataTable.Buttons.defaults.dom.button, {
        className: 'btn'
      })
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
          style: 'multi+shift',
          selector: 'td:first-child'
        },
        order: [],
        scrollX: true,
        pageLength: 100,
        dom: 'lBfrtip<"actions">',
        buttons: [{
            extend: 'selectAll',
            className: 'btn-primary',
            text: selectAllButtonTrans,
            exportOptions: {
              columns: ':visible'
            },
            action: function(e, dt) {
              e.preventDefault()
              dt.rows().deselect();
              dt.rows({
                search: 'applied'
              }).select();
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