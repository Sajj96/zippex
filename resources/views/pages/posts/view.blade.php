@extends('layouts.master', ['title' => 'Post Details'])

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
@endsection

@section('workspace')
@section('breadcrumb')
<div class="block-header">
    <div class="row">
        <div class="col-lg-7 col-md-6 col-sm-12">
            <h2>Post Details</h2>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="zmdi zmdi-home"></i> Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('blog') }}">Blog Posts</a></li>
                <li class="breadcrumb-item active">{{ $post->title }}</li>
            </ul>
            <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
        </div>
        <div class="col-lg-5 col-md-6 col-sm-12">
            <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
        </div>
    </div>
</div>
@endsection

<div class="container">
    <div class="row">
        <div class="col-lg-8 col-md-12">
            <div class="card">
                <div class="blogitem mb-5">
                    <div class="blogitem-image">
                        <a href="blog-details.html"><img src="{{ $post->image_path }}" alt="blog image"></a>
                        <span class="blogitem-date">{{ date('l, F d, Y') }}</span>
                    </div>
                    <div class="blogitem-content">
                        <div class="blogitem-header">
                            <div class="blogitem-meta">
                                <span><i class="zmdi zmdi-account"></i>By <a href="javascript:void(0);">Admin</a></span>
                            </div>
                        </div>
                        <h5><a href="blog-details.html">{!! $post->title !!}</a></h5>
                        <p>{!! $post->description !!}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12">
            <div class="card">
                <div class="header">
                    <h2><strong>Categories</strong></h2>
                </div>
                <div class="body">
                    <ul class="list-unstyled mb-0 widget-categories">
                        <li><a href="javascript:void(0);">Business Report</a></li>
                        <li><a href="javascript:void(0);">Business Growth</a></li>
                        <li><a href="javascript:void(0);">Business Strategy</a></li>
                        <li><a href="javascript:void(0);">Financial Advise</a></li>
                        <li><a href="javascript:void(0);">Creative Idea</a></li>
                        <li><a href="javascript:void(0);">Marketing</a></li>
                    </ul>
                </div>
            </div>
            <div class="card">
                <div class="header">
                    <h2><strong>Recent</strong> Posts</h2>
                </div>
                <div class="body">
                    <ul class="list-unstyled mb-0 widget-recentpost">
                        <li>
                            <a href="blog-details.html"><img src="assets/images/image-gallery/1.jpg" alt="blog thumbnail"></a>
                            <div class="recentpost-content">
                                <a href="blog-details.html">Fundamental analysis services</a>
                                <span>August 01, 2018</span>
                            </div>
                        </li>
                        <li>
                            <a href="blog-details.html"><img src="assets/images/image-gallery/2.jpg" alt="blog thumbnail"></a>
                            <div class="recentpost-content">
                                <a href="blog-details.html">Steps to a successful Business</a>
                                <span>November 01, 2018</span>
                            </div>
                        </li>
                        <li>
                            <a href="blog-details.html"><img src="assets/images/image-gallery/3.jpg" alt="blog thumbnail"></a>
                            <div class="recentpost-content">
                                <a href="#blog-details.html">Development Progress Conference</a>
                                <span>December 01, 2018</span>
                            </div>
                        </li>
                        <li>
                            <a href="blog-details.html"><img src="assets/images/image-gallery/12.jpg" alt="blog thumbnail"></a>
                            <div class="recentpost-content">
                                <a href="blog-details.html">Steps to a successful Business</a>
                                <span>December 15, 2018</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@endsection