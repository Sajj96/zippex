@extends('layouts.master', ['title' => 'Packages'])

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
@endsection

@section('workspace')
@section('breadcrumb')
<div class="block-header">
    <div class="row">
        <div class="col-lg-7 col-md-6 col-sm-12">
            <h2>Packages</h2>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="zmdi zmdi-home"></i> Home</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0);">Packages</a></li>
            </ul>
            <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
        </div>
        <div class="col-lg-5 col-md-6 col-sm-12">
            <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
            <a href="{{ route('package.add') }}" class="btn btn-primary float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-plus"></i> Add Package</a>
        </div>
    </div>
</div>
@endsection

<div class="body_scroll">
    <div class="container-fluid">

        <!-- Exportable Table -->
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Packages</strong> list </h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Commission</th>
                                        <th>Level One</th>
                                        <th>Level Two</th>
                                        <th>Level Three</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($packages as $package)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $package->name }}</td>
                                        <td>{{ number_format($package->price) }}</td>
                                        <td>{{ number_format($package->commission) }}</td>
                                        <td>{{ number_format($package->level_one) }}</td>
                                        <td>{{ number_format($package->level_two) }}</td>
                                        <td>{{ number_format($package->level_three) }}</td>
                                        <td>
                                        <a href="{{ route('package.edit', $package->id) }}" class="btn btn-primary btn-sm"><i class="zmdi zmdi-edit"></i></a>
                                            <a href="#" class="btn btn-danger btn-sm" onclick="event.preventDefault(); document.getElementById('delete-form').submit();"><i class="zmdi zmdi-delete"></i></a>
                                            <form id="delete-form" action="{{ route('package.delete') }}">
                                                @csrf
                                                <input type="hidden" name="package_id" value="{{ $package->id }}">
                                            </form>
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
@endsection

@section('scripts')
<script src="{{ asset('assets/bundles/datatablescripts.bundle.js') }}"></script>
<script src="{{ asset('assets/js/pages/tables/jquery-datatable.js') }}"></script>
@endsection