@extends('layouts.master', ['title' => 'FAQs | Add Question'])

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
            <h2>Add Question</h2>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="zmdi zmdi-home"></i> Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('blog') }}">FAQs</a></li>
                <li class="breadcrumb-item active">Add Question</li>
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
            <form action="{{ route('faq.add') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="body">
                        <div class="form-group">
                            <label for="">Question</label>
                            <input type="text" class="form-control" name="question" placeholder="Enter question" required/>
                        </div>
                        <div class="form-group form-float">
                            <label for="">Answer</label>
                            <textarea name="answer" cols="30" rows="5" placeholder="Type answer..." class="form-control summernote" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-info waves-effect m-t-20">Save</button>
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