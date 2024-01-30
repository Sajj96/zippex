@extends('layouts.master', ['title' => 'Products | Add Product'])

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
            <h2>Add Product</h2>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="zmdi zmdi-home"></i> Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('product') }}">Products</a></li>
                <li class="breadcrumb-item active">Add Product</li>
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
                    <h2><strong>Product</strong> Details</h2>
                </div>
                <div class="body">
                    <form id="form_validation" method="POST" action="{{ route('product.add') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group form-float">
                            <label for="">Name</label>
                            <input type="text" class="form-control" placeholder="Enter product name" name="name" required autofocus>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4 form-float">
                                <label for="">Price</label>
                                <input type="number" class="form-control" placeholder="Enter price" name="price" required>
                            </div>
                            <div class="form-group col-md-4 form-float">
                                <label for="">Stock Quantity</label>
                                <input type="number" class="form-control" placeholder="Enter Stock quantity" name="quantity" required>
                            </div>
                            <div class="form-group col-md-4 form-float">
                                <label for="">Category</label>
                                <select class="form-control show-tick ms select2" data-placeholder="Select category" name="category">
                                    @foreach($product_categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group form-float">
                            <label for="">Image</label>
                            <input type="file" class="dropify" name="image">
                        </div>
                        <div class="form-group form-float">
                            <label for="">Description</label>
                            <textarea name="description" cols="30" rows="5" placeholder="Description" class="form-control summernote" required></textarea>
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
<script src="{{ asset('assets/plugins/summernote/dist/summernote.js') }}"></script>
<script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/dropify/js/dropify.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/forms/dropify.js') }}"></script>
<script>
    $(function() {
        $(".select2").select2({
            allowClear: true
        });

        $(".summernote").summernote();
    })
</script>
@endsection