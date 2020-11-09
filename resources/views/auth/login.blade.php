@extends('layouts.app')

@section('content')
    <section class="padding-bottom-350">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">{{ trans('msg.login') }}</div>
                        <div class="card-body">
                            <form method="POST" id="login-form" action="{{ route('login') }}">
                                @csrf
                                <div class="form-group-b row">
                                    <label for="username"
                                        class="col-md-4 col-form-label text-md-right required">{{ trans('msg.username') }}</label>
                                    <div class="col-md-6">
                                        <input id="username" type="text"
                                            class="form-control-b @error ('username') is-invalid @enderror" name="username"
                                            value="{{ old('username') }}" required autocomplete="username" autofocus>
                                        @error ('username')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group-b row">
                                    <label for="password"
                                        class="col-md-4 col-form-label text-md-right required">{{ trans('msg.password') }}</label>
                                    <div class="col-md-6">
                                        <input id="password" type="password"
                                            class="form-control-b @error ('password') is-invalid @enderror" name="password"
                                            required>
                                        @error ('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group-b row">
                                    <div class="col-md-6 offset-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                                {{ old('remember') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="remember">
                                                {{ trans('msg.remember_me') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group-b row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button id='login-btn' type="submit" class="btn btn-primary">
                                            {{ trans('msg.login') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
