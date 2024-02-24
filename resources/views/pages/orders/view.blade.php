@extends('layouts.master', ['title' => 'Orders | {{ $order->code }}'])

@section('styles')

@endsection

@section('workspace')
@section('breadcrumb')
<div class="block-header">
    <div class="row">
        <div class="col-lg-7 col-md-6 col-sm-12">
            <h2>Orders</h2>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="zmdi zmdi-home"></i> Home</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0);">Orders</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0);">{{ $order->code }}</a></li>
            </ul>
            <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
        </div>
        <div class="col-lg-5 col-md-6 col-sm-12">
            <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
        </div>
    </div>
</div>
@endsection

<div class="body_scroll">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="body">
                        <h5><strong>Order ID: </strong> #{{ $order->code }}</h5>
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <address>
                                    <strong>{{ ucwords($order->userName) }}.</strong><br>
                                    {{ $order->userAddress }}<br>
                                    <abbr title="Phone">Phone:</abbr> {{ $order->userPhone }}
                                </address>
                            </div>
                            <div class="col-md-6 col-sm-6 text-right">
                                <p class="mb-0"><strong>Order Date: </strong> {{ date('F, d Y', strtotime($order->created_at)) }}</p>
                                <p class="mb-0"><strong>Order Status: </strong> 
                                @if($order->status == 0)
                                <span class="badge badge-warning">Pending</span>
                                @elseif($order->status == 1)
                                <span class="badge badge-success">Confirmed</span>
                                @else
                                <span class="badge badge-danger">Cancelled</span>
                                @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-hover c_table theme-color">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Image</th>
                                            <th width="60px">Item</th>
                                            <th>Category</th>
                                            <th>Quantity</th>
                                            <th>Unit Cost</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order->products as $product)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td><img src="{{ $product->productImage }}" width="40" alt="Product img"></td>
                                            <td>{{ $product->productName }}</td>
                                            <td>{{ $product->productCategory }}</td>
                                            <th>{{ $product->quantity }}</th>
                                            <td class="hidden-sm-down">{{ number_format($product->productPrice) }}</td>
                                            <td>{{ number_format($product->pivot->amount) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Note</h5>
                            </div>
                            <div class="col-md-6 text-right">
                                <ul class="list-unstyled">
                                    <li><strong>Sub-Total:-</strong> {{ number_format($order->totalAmount) }}</li>
                                </ul>
                                <h3 class="mb-0 text-success">TZS {{ number_format($order->totalAmount) }}</h3>
                                <a href="javascript:void(0);" class="btn btn-info"><i class="zmdi zmdi-print"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

@endsection