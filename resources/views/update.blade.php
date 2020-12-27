@extends('layouts.admin')

@section('content')

<a href="{{ route('update_tiki') }}" class="btn btn-primary"> {{ trans('msg.update_tiki_review') }} </a>
<br>
<br>
<a href="{{ route('update_shopee') }}" class="btn btn-primary"> {{ trans('msg.update_shopee_review') }} </a>

@endsection
