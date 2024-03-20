@extends('layouts.master', ['title' => 'Packages | Add Package'])

@section('workspace')
@section('breadcrumb')
<div class="block-header">
    <div class="row">
        <div class="col-lg-7 col-md-6 col-sm-12">
            <h2>Add Package</h2>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="zmdi zmdi-home"></i> Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('package') }}">Packages</a></li>
                <li class="breadcrumb-item active">Add Package</li>
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
                    <h2><strong>Add</strong> Package</h2>
                </div>
                <div class="body">
                    <form method="POST" action="{{ route('package.add') }}">
                        @csrf
                        <div class="form-group form-float">
                            <label for="">Name</label>
                            <input type="text" class="form-control" placeholder="Enter name" name="name" required>
                        </div>
                        <div class="form-group form-float">
                            <label for="">Price</label>
                            <input type="number" class="form-control" placeholder="Enter price" name="price" required>
                        </div>
                        <div class="form-group form-float">
                            <label for="">Commission</label>
                            <input type="number" class="form-control" placeholder="Enter commission" name="commission" required>
                        </div>
                        <div class="form-group form-float">
                            <label for="">Level One Earning</label>
                            <input type="number" class="form-control" placeholder="Enter level one earning" name="level_one" required>
                        </div>
                        <div class="form-group form-float">
                            <label for="">Level Two Earning</label>
                            <input type="number" class="form-control" placeholder="Enter level two earning" name="level_two" required>
                        </div>
                        <div class="form-group form-float">
                            <label for="">Level Three Earning</label>
                            <input type="number" class="form-control" placeholder="Enter level three earning" name="level_three" required>
                        </div>
                        <button type="submit" class="btn btn-raised btn-primary waves-effect submit-btn">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

@endsection