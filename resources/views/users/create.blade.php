@extends('layouts.admin')

@section('content')
    <div class="col-lg-10 offset-lg-1">
        @if (session('fail_status'))
            <div class="toast noti text-danger" data-delay="{{ config('default.noti_time') }}">
                <div class="toast-header">
                    <strong class="mr-auto">{{ trans('msg.notification') }}</strong>
                    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
                </div>
                <div class="toast-body">
                    {{ session('fail_status') }}
                </div>
            </div>
        @endif
        @if (session('status'))
            <div class="toast noti text-success" data-delay="{{ config('default.noti_time') }}">
                <div class="toast-header">
                    <strong class="mr-auto">{{ trans('msg.notification') }}</strong>
                    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
                </div>
                <div class="toast-body">
                    {{ session('status') }}
                </div>
            </div>
        @endif
        <div class="card">
            <div class="card-header">
                <strong>{{ trans('msg.add_user') }}</strong>
            </div>
            <div class="card-body card-block">
                <form action="{{ route('users.store') }}" id="form" method="POST" enctype="multipart/form-data"
                    class="form-horizontal">
                    @csrf
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="text-input" class=" form-control-label required">{{ trans('msg.name') }}</label>
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
                            <label for="text-input" class=" form-control-label required">{{ trans('msg.email') }}</label>
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
                            <label for="text-input" class=" form-control-label required">{{ trans('msg.username') }}</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" name="username" class="form-control @error ('username') is-invalid @enderror"
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
                            <label for="text-input" class=" form-control-label required">{{ trans('msg.password') }}</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="password" name="password"
                                class="form-control @error ('password') is-invalid @enderror" value="{{ old('password') }}"
                                required>
                            @error ('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="text-input" class=" form-control-label required">{{ trans('msg.pass_confirm') }}</label>
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
