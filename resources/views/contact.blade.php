@extends('layouts.app')

@section('content')
    <div class="padding-bottom-18 col-6 offset-3">
        <div class="section-heading heading-dark">
            <a class="btn btn-primary pull-right" role="button" href="{{ route('contacts.index') }}">
                <i class="fas fa-list"></i> {{ trans('msg.sent_req') }}
            </a>
            <h3 class="item-heading-big">{{ trans('msg.send_us_req') }}</h3>
        </div>
        <form id="contact-form" class="contact-form-box" method="POST" action="{{ route('contacts.store') }}">
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
