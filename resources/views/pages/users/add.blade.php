@extends('layouts.master', ['title' => 'User | Add User'])

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/summernote/dist/summernote.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/select2.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/plugins/dropify/css/dropify.min.css') }}">
@endsection

@section('workspace')
@section('breadcrumb')
<div class="block-header">
    <div class="row">
        <div class="col-lg-7 col-md-6 col-sm-12">
            <h2>Add User</h2>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="zmdi zmdi-home"></i> Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('user') }}">Users</a></li>
                <li class="breadcrumb-item active">Add User</li>
            </ul>
            <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
        </div>
        <div class="col-lg-5 col-md-6 col-sm-12">
            <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
        </div>
    </div>
</div>
@endsection

<div class="container-fluid">
    <!-- Basic Validation -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="header">
                    <h2><strong>User</strong> Details</h2>
                </div>
                <div class="body">
                    <form id="form_validation" method="POST" action="{{ route('user.add') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6 form-float">
                                <label for="">Name</label>
                                <input type="text" class="form-control" placeholder="Enter full name" name="name" value="{{ old('name') }}" required autofocus>
                            </div>
                            <div class="form-group col-md-6 form-float">
                                <label for="">Username</label>
                                <input type="text" class="form-control" placeholder="Enter username" name="username" value="{{ old('username') }}" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6 form-float">
                                <label for="">Email</label>
                                <input type="email" class="form-control" placeholder="Enter email address" name="email" value="{{ old('email') }}" required>
                            </div>
                            <div class="form-group col-md-6 form-float">
                                <label for="">Phone</label>
                                <input type="number" class="form-control" placeholder="Enter phone number" name="phone" value="{{ old('phone') }}" required>
                            </div>
                            <div class="form-group col-md-6 form-float">
                                <label for="">Roles</label>
                                <select class="form-control show-tick ms select2" data-placeholder="Select role(s)" name="roles">
                                    @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button class="btn btn-raised btn-primary waves-effect" type="submit">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="{{ asset('assets/plugins/jquery-validation/jquery.validate.js') }}"></script>
<script src="{{ asset('assets/js/pages/forms/form-validation.js') }}"></script>
<script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
<script>
    $(function() {
        $(".select2").select2({
            allowClear: true
        });

        $(".summernote").summernote();
    })
</script>
@endsection