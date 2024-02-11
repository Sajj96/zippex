@extends('layouts.master', ['title' => ' Roles | Edit Role'])

@section('workspace')
@section('breadcrumb')
<div class="block-header">
    <div class="row">
        <div class="col-lg-7 col-md-6 col-sm-12">
            <h2>Edit Role</h2>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="zmdi zmdi-home"></i> Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('role') }}">Roles</a></li>
                <li class="breadcrumb-item active">Edit Role</li>
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
                    <h2><strong>Edit</strong> Role</h2>
                </div>
                <div class="body">
                    <form method="POST" action="{{ route('role.edit') }}">
                        @csrf
                        <div class="form-group form-float">
                            <label for="">Name</label>
                            <input type="text" class="form-control" value="{{ $role->name }}" placeholder="Enter name" name="name" required>
                            <input type="hidden" name="id" value="{{ $role->id }}">
                        </div>
                        <div class="checkbox">
                            <input id="select_all" type="checkbox" class="select_all">
                            <label for="select_all">
                                Select All Permissions
                            </label>
                        </div>
                        <button type="submit" class="btn btn-raised btn-primary waves-effect submit-btn">Save Changes</button>
                        <div class="row">
                            @foreach($permissions as $permission)
                            <div class="col-md-4">
                                <div class="card px-4"  style="border: 1px solid #ced4da;">
                                    <div class="header">
                                        <h2><strong>{{ $permission['name'] }}</strong></h2>
                                    </div>
                                    <div class="body">
                                        @foreach($permission[\App\Models\PermissionSet::PERMISSIONS_LABEL] as $perm)
                                        <div class="checkbox">
                                            <input id="{{ $perm['pem'] }}" type="checkbox" class="permissions" @if(in_array($perm['pem'], $rolePermissions)) checked="checked" @endif name="permissions[]" value="{{ $perm['pem'] }}">
                                            <label for="{{ $perm['pem'] }}">{{ $perm['label'] }}</label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endforeach
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
    let selectAll = document.querySelector('.select_all');
    let permissions = document.querySelectorAll('.permissions');

    selectAll.addEventListener('change', (event) => {
        
        if (event.target.checked == true) {
            for (var i = 0; i < permissions.length; i++) {
                if (permissions[i].type == 'checkbox') {
                    permissions[i].checked = true;
                }
            }
        } else {
            for (var i = 0; i < permissions.length; i++) {
                if (permissions[i].type == 'checkbox') {
                    permissions[i].checked = false;
                }
            }
        }
    });

    for (var i = 0; i < permissions.length; i++) {
        permissions[i].addEventListener('change', (event) => {
            if (selectAll.checked === true) {
                selectAll.checked = false;
            }
        });
    }
</script>
@endsection