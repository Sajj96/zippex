@extends('layouts.master', ['title' => 'Blog Posts'])

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
@endsection

@section('workspace')
@section('breadcrumb')
<div class="block-header">
    <div class="row">
        <div class="col-lg-7 col-md-6 col-sm-12">
            <h2>Blog Posts</h2>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="zmdi zmdi-home"></i> Home</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0);">Blog Posts</a></li>
            </ul>
            <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
        </div>
        <div class="col-lg-5 col-md-6 col-sm-12">
            <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
            <a href="{{ route('blog.add') }}" class="btn btn-primary float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-plus"></i> Add Post</a>
        </div>
    </div>
</div>
@endsection

<div class="container">
    <div class="row">
        @foreach($posts as $post)
        <div class="col-md-6">
            <div class="card">
                <div class="blogitem mb-5">
                    <div class="blogitem-image">
                        <a href="{{ route('blog.show', $post->id ) }}"><img src="{{ $post->image_path }}" alt="blog image"></a>
                        <span class="blogitem-date">{{ date('l, F d, Y') }}</span>
                    </div>
                    <div class="blogitem-content">
                        <div class="blogitem-header">
                            <div class="blogitem-meta">
                                <span><i class="zmdi zmdi-account"></i>By <a href="javascript:void(0);">Admin</a></span>
                            </div>
                        </div>
                        <h5><a href="{{ route('blog.show', $post->id) }}">{!! $post->title !!}</a></h5>
                        <p>{!! $post->limit() !!}</p>
                        <a href="{{ route('blog.show', $post->id) }}" class="btn btn-info">Read More</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/bundles/datatablescripts.bundle.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-datatable/buttons/buttons.flash.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/tables/jquery-datatable.js') }}"></script>
@endsection