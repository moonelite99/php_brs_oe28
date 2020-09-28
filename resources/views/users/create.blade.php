@extends('layouts.admin')

@section('content')
    <div class="col-lg-10 offset-lg-1">
        <div class="card">
            <div class="card-header">
                <strong>{{ trans('msg.add_user') }}</strong>
            </div>
            <div class="card-body card-block">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <form action="{{ route('users.store') }}" id="form" method="POST" enctype="multipart/form-data"
                    class="form-horizontal">
                    @csrf
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="text-input" class=" form-control-label">{{ trans('msg.name') }}</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" name="name" class="form-control @error ('name') is-invalid @enderror"
                                value="{{ old('name') }}" autofocus required>
                            @error ('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="text-input" class=" form-control-label">{{ trans('msg.email') }}</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="email" name="email" class="form-control @error ('email') is-invalid @enderror"
                                value="{{ old('email') }}" required>
                            @error ('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="text-input" class=" form-control-label">{{ trans('msg.username') }}</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" name="username"
                                class="form-control @error ('username') is-invalid @enderror"
                                value="{{ old('username') }}" required>
                            @error ('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="text-input" class=" form-control-label">{{ trans('msg.password') }}</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="password" name="password"
                                class="form-control @error ('password') is-invalid @enderror"
                                value="{{ old('password') }}" required>
                            @error ('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="text-input" class=" form-control-label">{{ trans('msg.pass_confirm') }}</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="password" name="password_confirmation"
                                class="form-control @error ('password_confirmation') is-invalid @enderror" required>
                            @error ('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <button type="submit" form="form" class="btn btn-primary btn-sm pull-right">
                    {{ trans('msg.submit') }}
                </button>
            </div>
        </div>
    </div>
@endsection
