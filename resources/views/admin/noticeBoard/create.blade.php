@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.create') }} Notice
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route("admin.noticeboards.store") }}" enctype="multipart/form-data">
                        @csrf
                         <div class="row">
                             <div class="col-md-6">
                                <div class="form-group {{ $errors->has('notice_date') ? 'has-error' : '' }}">
                                    <label class="required" for="notice_date">Notice Date</label>
                                    <input class="form-control" type="date" name="notice_date" id="notice_date" value="{{ old('notice_date', '') }}" required>
                                    @if($errors->has('notice_date'))
                                        <span class="help-block" role="alert">{{ $errors->first('notice_date') }}</span>
                                    @endif                            
                                </div>
                                <div class="form-group {{ $errors->has('notice_title') ? 'has-error' : '' }}">
                                    <label class="required" for="notice_title">Notice Title</label>
                                    <input class="form-control" type="text" name="notice_title" id="notice_title" value="{{ old('notice_title', '') }}" required placeholder="Enter notice title">
                                    <input class="form-control" type="hidden" name="token" id="setToken">
                                    @if($errors->has('notice_title'))
                                        <span class="help-block" role="alert">{{ $errors->first('notice_title') }}</span>
                                    @endif                            
                                </div>
                                <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" name="description" id="description"></textarea>
                                    @if($errors->has('description'))
                                        <span class="help-block" role="alert">{{ $errors->first('description') }}</span>
                                    @endif
                                </div>
                                 

                             </div>
                             <div class="col-md-6">
                                

                                <div class="form-group {{ $errors->has('department') ? 'has-error' : '' }}">
                                    <label  for="department_id">{{ trans('cruds.employee.fields.department') }}</label>
                                    <select class="form-control select2" name="department_id" id="department_id">
                                        <option value="" selected>
                                           All
                                        </option>
                                        @foreach($departments as $id => $entry)
                                            <option value="{{ $entry->id }}">
                                                {{ $entry->department_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('department'))
                                        <span class="help-block" role="alert">{{ $errors->first('department') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.employee.fields.department_helper') }}</span>
                                </div>
                                <div class="form-group {{ $errors->has('employee') ? 'has-error' : '' }}">
                                    <label class="" for="employee_id">{{ trans('cruds.leaveApplication.fields.employee') }}</label>
                                    <select class="form-control select2" name="employee_id" id="employee_id" >
                                        <option value=""  selected>
                                            All
                                         </option>
                                        @foreach($employees as $id => $entry)
                                            <option value="{{ $entry->id }}">{{ $entry->first_name }} ({{$entry->employee_manual_id}})</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('employee'))
                                        <span class="help-block" role="alert">{{ $errors->first('employee') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.leaveApplication.fields.employee_helper') }}</span>
                                </div>
                             </div>

                         </div>

                        <div class="form-group">
                            <button class="button" type="submit" style="background-color: #605CA8;color: white;">
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
@section('scripts')

    <script>
        ClassicEditor
            .create(document.querySelector('#description'))
            .catch(error =>{
                console.log(error);
            });
    </script>


<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase.js"></script>
<script>
    var firebaseConfig = {
        apiKey: "AIzaSyD7LDBq_L-M16SGafbOS8dtGcCKmw0PlCA",
    authDomain: "hrims-d0499.firebaseapp.com",
    projectId: "hrims-d0499",
    storageBucket: "hrims-d0499.appspot.com",
    messagingSenderId: "727064288768",
    appId: "1:727064288768:web:7acdd4a96d79e2eabe02e5"
    };
    firebase.initializeApp(firebaseConfig);
    const messaging = firebase.messaging();
    
        messaging
            .requestPermission()
            .then(function () {
                return messaging.getToken()
            })
            .then(function (response) {
              
                var token = response;
                document.getElementById('setToken').value= token;
                // $.ajaxSetup({
                //     headers: {
                //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                //     }
                // });
                // $.ajax({
                //     url: '{{ route("admin.noticeboards.store") }}',
                //     type: 'POST',
                //     data: {
                //         token: response
                //     },
                //     dataType: 'JSON',
                //     success: function (response) {
                //         alert('Token stored.');
                //     },
                //     error: function (error) {
                //         alert(error);
                //     },
                // });
            }).catch(function (error) {
                alert(error);
            });
    
    messaging.onMessage(function (payload) {
        const title = payload.notification.title;
        const options = {
            body: payload.notification.body,
            icon: payload.notification.icon,
        };
        new Notification(title, options);
    });
</script>
@endsection
