@extends('layouts.admin')
@section('content')

<div class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Software Settings
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route("profile.password.updateProfile") }}">
                        @csrf
                        <div class="form-group">
                            <label class="required" for="name">Company Title</label>
                            <input class="form-control" type="text" name="company_name" id="company_name" value="" required>
                        </div>
                        <div class="form-group">
                            <label class="required" for="title">Email</label>
                            <input class="form-control" type="text" name="email" id="email" value="" required>
                        </div>
                        <div class="form-group">
                            <label class="required" for="title">Phone</label>
                            <input class="form-control" type="text" name="phone" id="phone" value="" required>
                        </div>
                        <div class="form-group">
                            <label class="required" for="title">Address</label>
                            <input class="form-control" type="text" name="address" id="address" value="" required>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Additional Setting
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route("profile.password.update") }}">
                        @csrf
                        <div class="form-group">
                            <label class="required" for="logo">Logo</label>
                            <input type="file" class="form-control-file" id="exampleFormControlFile1" required>
                        </div>
                        <div class="form-group">
                            <label class="required" for="role_id">Role ID</label>
                            <input class="form-control" type="role_id" name="role_id" id="role_id" required>
                        </div>
                        <div class="form-group">
                            <label class="required" for="prefix">Prefix</label>
                            <input class="form-control" type="prefix" name="prefix" id="prefix" required>
                        </div>
                        <div class="form-group">
                            <label class="required" for="developed_by">Developed By</label>
                            <input class="form-control" type="developed_by" name="developed_by" id="developed_by" required>
                        </div>
                    </form>

                    <div class="form-group">
                        <button class="btn btn-danger" type="submit">
                            {{ trans('global.save') }}
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.delete_account') }}
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route("profile.password.destroyProfile") }}" onsubmit="return prompt('{{ __('global.delete_account_warning') }}') == '{{ auth()->user()->email }}'">
                        @csrf
                        <div class="form-group">
                            <button class="btn btn-danger" type="submit">
                                {{ trans('global.delete') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection