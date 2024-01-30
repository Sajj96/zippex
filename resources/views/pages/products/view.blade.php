@extends('layouts.master', ['title' => 'Products | {{ $product->name }}'])

@section('styles')
@endsection

@section('workspace')
@section('breadcrumb')
<div class="block-header">
    <div class="row">
        <div class="col-lg-7 col-md-6 col-sm-12">
            <h2>{{ $product->name }}</h2>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="zmdi zmdi-home"></i> Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('product') }}">Products</a></li>
                <li class="breadcrumb-item active">{{ $product->name }}</li>
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
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="body">
                    <div class="row">
                        <div class="col-xl-3 col-lg-4 col-md-12">
                            <div class="preview preview-pic tab-content">
                                <div class="tab-pane active" id="product_1"><img src="{{ $product->image_path }}" class="img-fluid" alt="" /></div>
                            </div>
                            <ul class="preview thumbnail nav nav-tabs">
                                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#product_1"><img src="{{ $product->image_path }}" alt="" /></a></li>
                            </ul>
                        </div>
                        <div class="col-xl-9 col-lg-8 col-md-12">
                            <div class="product details">
                                <h3 class="product-title mb-0">{{ ucwords($product->name) }}</h3>
                                <h5 class="price mt-0">Price: <span class="col-amber">Tsh {{ number_format($product->price) }}</span></h5>
                                <hr>
                                <p class="product-description">{!! $product->description !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection