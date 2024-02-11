@extends('layouts.master', ['title' => 'Users'])

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
@endsection

@section('workspace')
@section('breadcrumb')
<div class="block-header">
    <div class="row">
        <div class="col-lg-7 col-md-6 col-sm-12">
            <h2>Profile</h2>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html"><i class="zmdi zmdi-home"></i> Home</a></li>
                <li class="breadcrumb-item active">Profile</li>
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
            <div class="col-lg-4 col-md-12">
                <div class="card mcard_3">
                    <div class="body">
                        <a href="profile.html"><img src="{{ asset('assets/images/avatar.png')}}" class="rounded-circle shadow " alt="profile-image"></a>
                        <h4 class="m-t-10">{{ ucwords($user->name) }}</h4>
                        <h6>@ {{ $user->username }}</h6>
                        <div class="row">
                            <div class="col-12">
                                <p class="text-muted">795 Folsom Ave, Suite 600 San Francisco, CADGE 94107</p>
                            </div>
                            <div class="col-4">
                                <small>Profit</small>
                                <h5>852</h5>
                            </div>
                            <div class="col-4">
                                <small>Orders</small>
                                <h5>13k</h5>
                            </div>
                            <div class="col-4">
                                <small>Referrals</small>
                                <h5>234</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="body">
                        <small class="text-muted">Email address: </small>
                        <span>{{ $user->email }}</span>
                        <hr>
                        <small class="text-muted">Phone: </small>
                        <span>{{ $user->phone }}</span>
                        <hr>
                        <small class="text-muted">Status: </small>
                        @if($user->status == 1)
                        <span class="badge badge-success badge-lg mr-2">Active</span>
                        @else
                        <span class="badge badge-danger mr-2">Inactive</span>
                        @endif
                        <hr>
                        <small class="text-muted">Referrer: </small>
                        <span>{{ $user->referrer->name ?? 'Not Specified' }}</span>
                        <hr>
                        <small class="text-muted">Referrals: </small>
                        <span>{{ count($user->referrals)  ?? '0' }}</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="card">
                    <div class="body">
                        <ul class="nav nav-tabs p-0 mb-3">
                            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#order">ORDERS</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#levelone">LEVEL ONE</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#leveltwo">LEVEL TWO</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#level">LEVEL THREE</a></li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane in active" id="order">
                                <b>Home Content</b>
                                <p> Lorem ipsum dolor sit amet, Pri ut tation electram moderatius.
                                    Per te suavitate democritum. Duis nemore probatus ne quo, ad liber essent aliquid
                                    pro. Et eos nusquam accumsan, vide mentitum fabellas ne est, eu munere gubergren
                                    sadipscing mel. </p>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="levelone">
                                <b>Profile Content</b>
                                <p> Lorem ipsum dolor sit amet, ut duo atqui exerci dicunt, ius impedit mediocritatem an. Pri ut tation electram moderatius.
                                    Per te suavitate essent aliquid
                                    pro. Et eos nusquam accumsan, vide mentitum fabellas ne est, eu munere gubergren
                                    sadipscing mel. </p>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="leveltwo">
                                <b>Message Content</b>
                                <p> ius impedit mediocritatem an. Pri ut tation electram moderatius.
                                    Per te suavitate democritum. Duis nemore probatus ne quo, ad liber essent aliquid
                                    pro. Et eos nusquam accumsan, vide mentitum fabellas ne est, eu munere gubergren
                                    sadipscing mel. </p>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="level">
                                <b>Settings Content</b>
                                <p> Lorem ipsum dolor sit amet, ut duo atqui exerci dicunt, ius impedit mediocritatem an. Pri ut tation electram moderatius.
                                    Per te suavitate democritum. Duis nemore probatus ne quo, ad liber essent aliquid
                                    pro. </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection