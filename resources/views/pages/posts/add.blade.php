@extends('layouts.master', ['title' => 'Blogs | Add Post'])

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
            <h2>Add Post</h2>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="zmdi zmdi-home"></i> Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('blog') }}">Blog Posts</a></li>
                <li class="breadcrumb-item active">Add Post</li>
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
    <div class="row">
        <div class="col-lg-12">
            <form action="{{ route('blog.add') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="body">
                        <div class="form-group">
                            <label for="">Title</label>
                            <input type="text" class="form-control" name="title" placeholder="Enter Blog title" required/>
                        </div>
                        <div class="form-group form-float">
                            <label for="">Category</label>
                            <select class="form-control show-tick ms select2" data-placeholder="Select category" name="category" required>
                                @foreach($post_categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group form-float">
                            <label for="">Image</label>
                            <input type="file" class="dropify" name="image">
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="body">
                        <h6>Descriptions</h6>
                        <textarea name="description" cols="30" rows="5" placeholder="Description" class="form-control summernote" required></textarea>
                        <button type="submit" class="btn btn-info waves-effect m-t-20">POST</button>
                    </div>
                </div>
            </form>
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