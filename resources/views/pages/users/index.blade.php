@extends('layouts.master', ['title' => 'Customers'])

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
@endsection

@section('workspace')
@section('breadcrumb')
<div class="block-header">
    <div class="row">
        <div class="col-lg-7 col-md-6 col-sm-12">
            <h2>Customers</h2>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="zmdi zmdi-home"></i> Home</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0);">Customers</a></li>
            </ul>
            <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
        </div>
        <div class="col-lg-5 col-md-6 col-sm-12">
            <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
            <a href="{{ route('product.add') }}" class="btn btn-primary float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-plus"></i> Add User</a>
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
                        <h2><strong>Customers</strong> list </h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            {!! $dataTable->table() !!}
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
<script src="{{ asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-datatable/buttons/buttons.flash.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/tables/jquery-datatable.js') }}"></script>
<script type="text/javascript">
    $(function() {
        window.LaravelDataTables = window.LaravelDataTables || {};
        window.LaravelDataTables["users-table"] = $("#users-table").DataTable({
            "serverSide": true,
            "processing": true,
            "dom": "Bfrtp",
            "ajax": "{{ route('user') }}",
            "columns": [{
                    "data": "DT_RowIndex",
                    "name": "id",
                    "title": "Id",
                    "orderable": true,
                    "searchable": true
                }, {
                    "data": "name",
                    "name": "name",
                    "title": "Name",
                    "orderable": true,
                    "searchable": true
                }, {
                    "data": "username",
                    "name": "username",
                    "title": "Username",
                    "orderable": true,
                    "searchable": true
                }, {
                    "data": "email",
                    "name": "email",
                    "title": "Email",
                    "orderable": true,
                    "searchable": true
                }, {
                    "data": "phone",
                    "name": "phone",
                    "title": "Phone",
                    "orderable": true,
                    "searchable": true
                }, {
                    "data": "referrer",
                    "name": "referrer",
                    "title": "Referrer",
                    "orderable": true,
                    "searchable": true
                }, {
                    "data": "referrals",
                    "name": "referrals",
                    "title": "Referrals",
                    "orderable": true,
                    "searchable": true
                }, {
                    "data": "joined",
                    "name": "joined",
                    "title": "Fare Amount",
                    "orderable": true,
                    "searchable": true
                }, {
                    "data": "status",
                    "name": "status",
                    "title": "Status",
                    "orderable": false,
                    "searchable": false,
                    "width": 60,
                    "className": "text-center"
                },
                {
                    "data": "action",
                    "name": "action",
                    "title": "Action",
                    "orderable": false,
                    "searchable": false,
                    "width": 60,
                    "className": "text-center"
                }
            ],
            "order": [
                [1, "desc"]
            ],
            "select": {
                "style": "single"
            },
            "buttons": [{
                "extend": "excel"
            }, {
                "extend": "print"
            }]
        });
    });
</script>
@endsection