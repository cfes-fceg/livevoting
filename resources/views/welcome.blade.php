@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-5 mt-4 mb-4 mx-auto">
            <img src="/images/cfes-logo.svg" alt="CFES Logo"/>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body d-flex">
                    <form class="my-auto w-100" method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="input-group mb-3">
                            <div class="input-group-prepend col-4 col-lg-3 p-0">
                                <label for="email"
                                       class="input-group-text w-100">{{ __('E-Mail Address') }}</label>
                            </div>
                            <input
                                type="text"
                                name="email"
                                class="form-control @if($errors->has('email') && Session::get('last_auth_attempt') == 'login') is-invalid @endif"
                                autocomplete="email"
                                aria-label="email"
                                value="{{ Session::get('last_auth_attempt') != 'login' ? '' : old('email') }}">

                            @if($errors->has('email') && Session::get('last_auth_attempt') == 'login')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend col-4 col-lg-3 p-0">
                                <label for="password"
                                       class="input-group-text w-100">{{ __('Password') }}</label>
                            </div>

                            <input id="password" type="password"
                                   class="form-control @if($errors->has('password') && Session::get('last_auth_attempt') == 'login') is-invalid @endif"
                                   name="password"
                                   required autocomplete="current-password">

                            @if($errors->has('password') && Session::get('last_auth_attempt') == 'login')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                            @endif

                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember"
                                           id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <button type="submit" class="btn btn-primary float-right">
                                    {{ __('Login') }}
                                </button>
                                <a class="btn btn-link float-right" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6 my-auto">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="input-group mb-3">
                            <div class="input-group-prepend col-5 col-lg-4 p-0">
                                <label for="name" class="input-group-text w-100">{{ __('Name') }}</label>
                            </div>

                            <input id="name"
                                   type="text"
                                   class="form-control @if($errors->has('name') && Session::get('last_auth_attempt') != 'login') is-invalid @endif"
                                   name="name"
                                   value="{{ Session::get('last_auth_attempt') == 'login' ? '' : old('name') }}"
                                   required
                                   autocomplete="name"
                            >

                            @if($errors->has('name') && Session::get('last_auth_attempt') != 'login')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                            @endif

                        </div>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend col-5 col-lg-4 p-0">
                                <label for="email"
                                       class="input-group-text w-100">{{ __('E-Mail Address') }}</label>
                            </div>

                            <input id="email" type="email"
                                   class="form-control @if($errors->has('email') && Session::get('last_auth_attempt') != 'login') is-invalid @endif"
                                   name="email"
                                   value="{{ Session::get('last_auth_attempt') == 'login' ?'': old('email') }}" required
                                   autocomplete="email">

                            @if($errors->has('email') && Session::get('last_auth_attempt') != 'login')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend col-5 col-lg-4 p-0">
                                <label for="password"
                                       class="input-group-text w-100">{{ __('Password') }}</label>
                            </div>

                            <input id="password" type="password"
                                   class="form-control @if($errors->has('password') && Session::get('last_auth_attempt') != 'login') is-invalid @endif"
                                   name="password"
                                   required autocomplete="new-password">

                            @if($errors->has('password') && Session::get('last_auth_attempt') != 'login')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                            @endif

                        </div>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend col-5 col-lg-4 p-0">
                                <label for="password-confirm"
                                       class="input-group-text w-100">{{ __('Confirm Password') }}</label>
                            </div>

                            <input id="password-confirm" type="password" class="form-control"
                                   name="password_confirmation" required autocomplete="new-password">

                        </div>

                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary float-right">
                                {{ __('Register') }}
                            </button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
