@extends('layouts.admin')
@section('content')

<div class="content">
    <div class="row">
        <div class="col-md-12">


            <div class="panel panel-default">
                <div class="panel-heading">
                    Software Settings
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route("admin.settings.store") }}" enctype="multipart/form-data" >
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="required" for="name">Company Title</label>
                                    <input class="form-control" type="text" name="company_title" id="company_title" value="{{$settings->company_title}}" required>
                                </div>
                                <div class="form-group">
                                    <label class="required" for="title">Email</label>
                                    <input class="form-control" type="email" name="company_email" id="email" value="{{$settings->company_email }}" required>
                                </div>
                                <div class="form-group">
                                    <label class="required" for="title">Phone</label>
                                    <input class="form-control" type="text" name="company_phone" id="phone" value="{{$settings->company_phone }}" required>
                                </div>
                                <div class="form-group">
                                    <label class="required" for="title">Address</label>
                                    <input class="form-control" type="text" name="company_address" id="address" value="{{$settings->company_address }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="required" for="role_id">Role ID</label>
                                    <input class="form-control" type="role_id" name="role_id" id="role_id" value="{{$settings->role_id }}" required>
                                </div>
                                <div class="form-group">
                                    <label class="required" for="prefix">Prefix</label>
                                    <input class="form-control" type="prefix" name="prefix" id="prefix" value="{{$settings->prefix }}" required>
                                </div>
                                <div class="form-group">
                                    <label class="required" for="developed_by">Developed By</label>
                                    <input class="form-control" type="developed_by" name="developed_by" id="developed_by" value="{{$settings->developed_by }}" required>
                                </div>


                                <div class="form-group " >
                                    <label class="required" for="logo">Logo</label>
                                    <input type="file" class="form-control-file" id="photo-dropzone" value="{{$settings->company_logo }}" name="company_logo">

                                    <label class="required" for="logo">Old Logo</label>
                                    <img src="{{url('images/settings/',$settings->company_logo)}}"  alt="" height="100" width="auto" >
                                </div>

                            </div>
                        <br>
                        <br>
                    </div>
                   <div class="form-group" style="float:left;">
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


<script>
    Dropzone.options.photoDropzone = {
        url: '{{ route('admin.settings.storeMedia') }}',
        maxFilesize: 2, // MB
        acceptedFiles: '.jpeg,.jpg,.png,.gif',
        maxFiles: 1,
        addRemoveLinks: true,
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        params: {
            size: 2,
            width: 4096,
            height: 4096
        },
        success: function(file, response) {
            $('form').find('input[name="company_logo"]').remove()
            $('form').append('<input type="hidden" name="company_logo" value="' + response.name + '">')
        },
        removedfile: function(file) {
            file.previewElement.remove()
            if (file.status !== 'error') {
                $('form').find('input[name="company_logo"]').remove()
                this.options.maxFiles = this.options.maxFiles + 1
            }
        },
        init: function() {
            @if(isset($settings) && $settings->company_logo)
            var file = { !!json_encode($settings->company_logo) !! }
            this.options.addedfile.call(this, file)
            this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
            file.previewElement.classList.add('dz-complete')
            $('form').append('<input type="hidden" name="company_logo" value="' + file.file_name + '">')
            this.options.maxFiles = this.options.maxFiles - 1
            @endif
        },
        error: function(file, response) {
            if ($.type(response) === 'string') {
                var message = response //dropzone sends it's own error messages in string
            } else {
                var message = response.errors.file
            }
            file.previewElement.classList.add('dz-error')
            _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
            _results = []
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                node = _ref[_i]
                _results.push(node.textContent = message)
            }

            return _results
        }
    }
</script>
@endsection

