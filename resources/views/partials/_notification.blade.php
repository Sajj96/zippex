<div class="py-2">
    @if($message = Session::get('success'))
    <div class="alert alert-success" role="alert">
        {{ $message }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true"><i class="zmdi zmdi-close"></i></span>
        </button>
    </div>
    @endif

    @if($message = Session::get('error'))
    <div class="alert alert-danger" role="alert">
        {{ $message }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true"><i class="zmdi zmdi-close"></i></span>
        </button>
    </div>
    @endif

    @if($message = Session::get('warning'))
    <div class="alert alert-warning" role="alert">
        {{ $message }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true"><i class="zmdi zmdi-close"></i></span>
        </button>
    </div>
    @endif

    @if($message = Session::get('info'))
    <div class="alert alert-info" role="alert">
        {{ $message }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true"><i class="zmdi zmdi-close"></i></span>
        </button>
    </div>
    @endif

    @if($message = Session::get('status'))
    <div class="alert alert-info" role="alert">
        {{ $message }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true"><i class="zmdi zmdi-close"></i></span>
        </button>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true"><i class="zmdi zmdi-close"></i></span>
        </button>
    </div>
    @endif

</div>