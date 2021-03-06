@extends('layouts.app')

@section('content')
    <section class="padding-bottom-200">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{ trans('msg.register') }}</div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="form-group-b row">
                                    <label for="name"
                                        class="col-md-4 col-form-label text-md-right required">{{ trans('msg.name') }}</label>
                                    <div class="col-md-6">
                                        <input id="name" type="text"
                                            class="form-control-b @error ('name') is-invalid @enderror" name="name"
                                            value="{{ old('name') }}" required autocomplete="name" autofocus>
                                        @error ('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group-b row">
                                    <label for="email"
                                        class="col-md-4 col-form-label text-md-right required">{{ trans('msg.email_address') }}</label>
                                    <div class="col-md-6">
                                        <input id="email" type="email"
                                            class="form-control-b @error ('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" required autocomplete="email">
                                        @error ('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group-b row">
                                    <label for="username"
                                        class="col-md-4 col-form-label text-md-right required">{{ trans('msg.username') }}</label>
                                    <div class="col-md-6">
                                        <input id="username" type="text"
                                            class="form-control-b @error ('username') is-invalid @enderror" name="username"
                                            value="{{ old('username') }}" required autocomplete="username">
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
                                            required autocomplete="new-password">
                                        @error ('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group-b row">
                                    <label for="password-confirm"
                                        class="col-md-4 col-form-label text-md-right required">{{ trans('msg.pass_confirm') }}</label>
                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control-b"
                                            name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div>
                                <div class="form-group-b row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ trans('msg.register') }}
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
