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
                            @if($user_address)
                            <div class="col-12">
                                <p class="text-muted">{{ $user_address->street.", ".$user_address->ward.", ".$user_address->district.", ". $user_address->region}}</p>
                            </div>
                            @endif
                            <div class="col-4">
                                <small>Profit</small>
                                <h5>{{ $profit }}</h5>
                            </div>
                            <div class="col-4">
                                <small>Orders</small>
                                <h5>{{ count($orders) }}</h5>
                            </div>
                            <div class="col-4">
                                <small>Referrals</small>
                                <h5>{{ count($user->referrals)  ?? '0' }}</h5>
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
                        <form class="delete-form" action="{{ route('user.deactivate') }}" method="POST">
                            @csrf
                            <input type="hidden" value="{{ $user->id }}" name="id">
                            <button type="submit" class="btn btn-danger btn-block btn-sm">Deactivate</button>
                        </form>
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
                                <b>Orders</b>
                                <div class="table-responsive">
                                    <table class="table table-hover c_table theme-color">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Code</th>
                                                <th>Address</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($orders as $order)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $order->code }}</td>
                                                <td>{{ $order->userAddress }}</td>
                                                <td>
                                                    @if($order->status == 0)
                                                    <span class="badge badge-warning mr-2">Pending</span>
                                                    @elseif($order->status == 1)
                                                    <span class="badge badge-success mr-2">Paid</span>
                                                    @else
                                                    <span class="badge badge-danger mr-2">Canceled</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="levelone">
                                <b>Level One ({{ $levelOne['activeReferrals'] }})</b>
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Username</th>
                                            <th>Phone No</th>
                                            <th>Earned</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($levelOne['downlines'] as $key=>$downline)
                                        <tr>
                                            <td>
                                                {{ $loop->iteration }}
                                            </td>
                                            <td>{{ $downline->username }}</td>
                                            <td>{{ $downline->phone }}</td>
                                            <td></td>
                                            <td>
                                                @if($downline->status == 1)
                                                <span class="badge badge-success mr-2">Active</span>
                                                @else
                                                <span class="badge badge-danger mr-2">Inactive</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="leveltwo">
                                <b>Level Two ({{$levelTwo['activeReferrals']}})</b>
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Username</th>
                                            <th>Phone No</th>
                                            <th>Earned</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($levelTwo['downlines'] as $key=>$downline)
                                        <tr>
                                            <td>
                                                {{ $loop->iteration }}
                                            </td>
                                            <td>{{ $downline->username }}</td>
                                            <td>{{ $downline->phone }}</td>
                                            <td></td>
                                            <td>
                                                @if($downline->status == 1)
                                                <span class="badge badge-success mr-2">Active</span>
                                                @else
                                                <span class="badge badge-danger mr-2">Inactive</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="level">
                                <b>Level Three ({{$levelThree['activeReferrals']}})</b>
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Username</th>
                                            <th>Phone No</th>
                                            <th>Earned</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($levelThree['downlines'] as $key=>$downline)
                                        <tr>
                                            <td>
                                                {{ $loop->iteration }}
                                            </td>
                                            <td>{{ $downline->username }}</td>
                                            <td>{{ $downline->phone }}</td>
                                            <td></td>
                                            <td>
                                                @if($downline->status == 1)
                                                <span class="badge badge-success mr-2">Active</span>
                                                @else
                                                <span class="badge badge-danger mr-2">Inactive</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection