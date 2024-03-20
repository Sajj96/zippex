@extends('layouts.master', ['title' => 'Dashboard'])

@section('workspace')
@section('breadcumb')
<div class="block-header">
    <div class="row">
        <div class="col-lg-7 col-md-6 col-sm-12">
            <h2>Dashboard</h2>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html"><i class="zmdi zmdi-home"></i> Home</a></li>
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
        <div class="col-md-12 col-lg-4">
            <div class="card">
                <div class="body">
                    <h3 class="mt-0 mb-0">{{ number_format($total_products) }}</h3>
                    <p class="text-muted">Total Products</p>
                    <div class="progress">
                        <div class="progress-bar l-amber" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 45%;"></div>
                    </div>
                    <small>21% higher than last month</small>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-4">
            <div class="card">
                <div class="body">
                    <h3 class="mt-0 mb-0">{{ number_format($total_orders) }}</h3>
                    <p class="text-muted">Total Orders</p>
                    <div class="progress">
                        <div class="progress-bar l-pink" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 45%;"></div>
                    </div>
                    <small>43% higher than last month</small>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-4">
            <div class="card">
                <div class="body">
                    <h3 class="mt-0 mb-0">{{ number_format($total_customers) }}</h3>
                    <p class="text-muted">Active Customers</p>
                    <div class="progress">
                        <div class="progress-bar l-green" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 45%;"></div>
                    </div>
                    <small>23% higher than last month</small>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-md-12 col-lg-12">
            <div class="card visitors-map">
                <div class="header">
                    <h2><strong>Popular</strong> Products</h2>
                </div>
                <div class="row">
                    <div class="col-xl-8 col-lg-8 col-md-12">
                        <div class="table-responsive">
                            <table class="table table-hover theme-color c_table">
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th></th>
                                        <th>Views</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="w70"><img class="w50" src="assets/images/ecommerce/1.png" alt=""></td>
                                        <td><a href="javascript:void(0)" class="text-muted">PlayStation 4 1TB (Jet Black)</a></td>
                                        <td>3,432</td>
                                    </tr>
                                    <tr>
                                        <td><img class="w50" src="assets/images/ecommerce/2.png" alt=""></td>
                                        <td><a href="javascript:void(0)" class="text-muted">Printed color block T-shirt</a></td>
                                        <td>852</td>
                                    </tr>
                                    <tr>
                                        <td><img class="w50" src="assets/images/ecommerce/3.png" alt=""></td>
                                        <td><a href="javascript:void(0)" class="text-muted">Wireless headphones</a></td>
                                        <td>1,321</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-12">
                        <div class="card w_data_1">
                            <div class="body">
                                <div class="w_icon cyan"><i class="zmdi zmdi-ticket-star"></i></div>
                                <h4 class="mt-3 mb-1">10.8k</h4>
                                <span class="text-muted">Total Sales</span>
                                <div class="w_description text-success">
                                    <i class="zmdi zmdi-trending-up"></i>
                                    <span>95.5%</span>
                                </div>
                                </di>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="header">
                    <h2><strong>Recent</strong> Orders</h2>
                    <ul class="header-dropdown">
                        <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                            <ul class="dropdown-menu dropdown-menu-right slideUp">
                                <li><a href="javascript:void(0);">Action</a></li>
                                <li><a href="javascript:void(0);">Another action</a></li>
                                <li><a href="javascript:void(0);">Something else</a></li>
                            </ul>
                        </li>
                        <li class="remove">
                            <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                        </li>
                    </ul>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover c_table">
                        <thead>
                            <tr>
                                <th style="width:60px;">#</th>
                                <th>Name</th>
                                <th>Item</th>
                                <th>Address</th>
                                <th>Quantity</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><img src="http://via.placeholder.com/60x40" alt="Product img"></td>
                                <td>Hossein</td>
                                <td>IPONE-7</td>
                                <td>Porterfield 508 Virginia Street Chicago, IL 60653</td>
                                <td>3</td>
                                <td><span class="badge badge-success">DONE</span></td>
                            </tr>
                            <tr>
                                <td><img src="http://via.placeholder.com/60x40" alt="Product img"></td>
                                <td>Camara</td>
                                <td>NOKIA-8</td>
                                <td>2595 Pearlman Avenue Sudbury, MA 01776 </td>
                                <td>3</td>
                                <td><span class="badge badge-success">DONE</span></td>
                            </tr>
                            <tr>
                                <td><img src="http://via.placeholder.com/60x40" alt="Product img"></td>
                                <td>Maryam</td>
                                <td>NOKIA-456</td>
                                <td>Porterfield 508 Virginia Street Chicago, IL 60653</td>
                                <td>4</td>
                                <td><span class="badge badge-success">DONE</span></td>
                            </tr>
                            <tr>
                                <td><img src="http://via.placeholder.com/60x40" alt="Product img"></td>
                                <td>Micheal</td>
                                <td>SAMSANG PRO</td>
                                <td>508 Virginia Street Chicago, IL 60653</td>
                                <td>1</td>
                                <td><span class="badge badge-success">DONE</span></td>
                            </tr>
                            <tr>
                                <td><img src="http://via.placeholder.com/60x40" alt="Product img"></td>
                                <td>Frank</td>
                                <td>NOKIA-456</td>
                                <td>1516 Holt Street West Palm Beach, FL 33401</td>
                                <td>13</td>
                                <td><span class="badge badge-warning">PENDING</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection