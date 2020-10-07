@extends('layouts.app')

@section('content')
    <div class="padding-bottom-18 col-6 offset-3">
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
        <div class="section-heading heading-dark">
            <h3 class="item-heading-big">{{ trans('msg.send_us_req') }}</h3>
        </div>
        <form id="contact-form" class="contact-form-box" method="POST" action="{{ route('contact.store') }}">
            @csrf
            <div class="row">
                <div class="col-12 form-group">
                    <textarea placeholder="{{ trans('msg.type_content') }}" class="textarea form-control @error ('contact') is-invalid @enderror" name="contact" rows="10" autofocus required></textarea>
                    @error ('contact')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="help-block with-errors"></div>
                    <br>
                    <button type="submit" class="item-btn pull-right mt-3">{{ trans('msg.submit') }}</button>
                </div>
                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                <div class="form-response"></div>
            </div>
        </form>
    </div>
@endsection
