@extends('layouts.app')

@section('workspace')
<div class="authentication">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-sm-12">
                <div class="card">
                    <img src="{{ asset('assets/images/boy-with-rocket-light.png') }}" width="500" alt="Sign In" />
                </div>
            </div>
            <div class="col-lg-4 col-sm-12">
                <form class="card auth_form" action="{{ route('login') }}" method="post">
                    @csrf
                    <div class="header">
                        <img class="logo" src="assets/images/logo.png" alt="">
                        <h5>{{ __('Login') }}</h5>
                    </div>
                    <div class="body">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control @error('login') is-invalid @enderror" name="login" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email/Username">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="zmdi zmdi-account-circle"></i></span>
                            </div>
                            @error('login')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="zmdi zmdi-lock"></i></span>
                            </div>
                        </div>
                        <div class="checkbox">
                            <input name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} type="checkbox">
                            <label for="remember">{{ __('Remember Me')}}</label>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block waves-effect waves-light">{{ __('SIGN IN')}}</button>
                    </div>
                </form>
                <div class="copyright text-center">
                    &copy;
                    <script>
                        document.write(new Date().getFullYear())
                    </script>,
                    <span><a href="#">Zippex</a></span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection